<?php

namespace App\Jobs;

use App\Contracts\IO\Export\ExportationServiceFactory;
use App\Logging\Log;
use App\Models\Task;
use App\Models\Tasks\ExportTask;
use App\Repository\Contracts\Interfaces\RepositoryInterface;
use App\Repository\Contracts\Viewable;
use Exception;

class ExportViewableJob extends Job
{
    /**
     * @param Task $task
     * @return static
     */
    public static function instance(Task $task): static
    {
        return new self(tenant(), $task);
    }

    /**
     * @throws Exception
     */
    protected function handleOnTenancyContext(): void
    {
        $this->task->update(['status_id' => ExportTask::EXPORT_PROCESSING_ID()]);

        try {
            $path = client_storage('exports' . DIRECTORY_SEPARATOR . strtoupper(md5(microtime())));

            /** @var Viewable|RepositoryInterface $repository */
            $repository = app($this->task->payload['repository']);
            $builder = $repository->viewableBuilder(null, $this->task->payload['filters']);

            $headers = client_config($this->task->payload['config'], 'columns');

            $viewableColumns = collect($repository->viewableColumns())
                ->flip()->only(collect($headers)->keys()->toArray())
                ->flip()->values()->toArray();

            $service = ExportationServiceFactory::make($this->task->payload['service']);
            $writable = $service->export($builder, $path, $viewableColumns, $headers);
        } catch (Exception $exception) {
            $this->task->update(['status_id' => ExportTask::EXPORT_FAILED_ID()]);

            Log::task($exception->getMessage(), [$this->task, $exception]);

            throw $exception;
        }

        $this->task->update(['status_id' => ExportTask::EXPORT_DONE_ID()]);

        $this->task->update([
            'payload' => array_merge(
                $this->task->payload,
                ['file' => $writable->getResourceId()]
            )
        ]);
    }

    protected function handleOnCentralContext(): void
    {
        //
    }
}
