<?php

namespace App\Jobs;

use App\Contracts\IO\Import\ImportationServiceFactory;
use App\Logging\Log;
use App\Models\Task;
use App\Models\Tasks\ImportTask;
use Exception;
use Illuminate\Support\LazyCollection;
use League\Flysystem\FileNotFoundException;
use Throwable;

class ImportJob extends Job
{
    /**
     * @param ImportTask|Task $task
     * @return static
     */
    public static function instance(ImportTask|Task $task): static
    {
        return new static(tenant(), $task->concrete());
    }

    /**
     * @throws FileNotFoundException
     * @throws Throwable
     */
    protected function handleOnTenancyContext(): void
    {
        $listing = ImportTask::getListingByCode(ImportTask::IMPORT_PROCESSING);
        $this->task->update(['status_id' => $listing->id]);

        try {
            $file = data_get($this->task->payload, "file");

            throw_if(
                !$file || !file_exists($file),
                FileNotFoundException::class,
                $file
            );

            $config = client_config(data_get($this->task->payload, 'config'));

            $rules = collect(data_get($config, 'columns'))
                ->map(fn (array $column) => $column['validation'])
                ->toArray();

            $service = data_get($this->task->payload, 'service') ?: data_get($config, 'format.default');

            ImportationServiceFactory::make($service)
                ->import(
                    $this->task,
                    LazyCollection::fromFile($file),
                    app($this->task->payload['repository']),
                    $rules
                );

            $this->task->concrete()->setListingState(ImportTask::IMPORT_DONE);
        } catch (Exception $exception) {
            $listing = ImportTask::getListingByCode(ImportTask::IMPORT_FAILED);
            $this->task->update([
                'status_id' => $listing->id,
                'comment' => $exception->getMessage()
            ]);

            Log::task($exception->getMessage(), [$this->task, $exception]);

            throw $exception;
        }
    }

    protected function handleOnCentralContext(): void
    {
        //
    }

    /**
     * @param Throwable $exception
     */
    public function failed(Throwable $exception)
    {
        $this->delete();
    }
}
