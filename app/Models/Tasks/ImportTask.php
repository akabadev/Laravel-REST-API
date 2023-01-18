<?php

namespace App\Models\Tasks;

use App\Contracts\IO\Import\Pipes\AssociateDataToRuleFields;
use App\Contracts\IO\Import\Pipes\CsvParser;
use App\Contracts\IO\Import\Pipes\ValidateData;
use App\Models\Contracts\CanBeValidated;
use App\Models\Contracts\HasDetails;
use App\Models\ImportProcessing;
use App\Models\Task;
use App\Repository\Contracts\Interfaces\RepositoryInterface;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Pipeline\Pipeline;
use League\Flysystem\FileNotFoundException;
use Throwable;

class ImportTask extends Task implements HasDetails, CanBeValidated
{
    public const IMPORT_PENDING = "IMPORT_PENDING";
    public const IMPORT_QUEUED = "IMPORT_QUEUED";
    public const IMPORT_PROCESSING = "IMPORT_PROCESSING";
    public const IMPORT_DONE = 'IMPORT_DONE';
    public const IMPORT_FAILED = 'IMPORT_FAILED';
    public const IMPORT_VALIDATION_PROCESSING = 'IMPORT_VALIDATION_PROCESSING';
    public const IMPORT_VALIDATION_DONE = 'IMPORT_VALIDATION_DONE';
    public const IMPORT_VALIDATION_FAILED = 'IMPORT_VALIDATION_FAILED';

    protected function concreteToArray(): array
    {
        return parent::concreteToArray();
    }

    public function import_processing(): HasMany
    {
        return $this->hasMany(ImportProcessing::class, 'task_id');
    }

    public function onQueue()
    {
        $this->update([$this->listingKeyName() => self::getListingByCode(self::IMPORT_QUEUED)->id]);
    }

    public function failed(string $message = "Une erreur est survenue"): void
    {
        $this->update([
            $this->listingKeyName() => self::getListingByCode(self::IMPORT_FAILED)->id,
            "comment" => $message
        ]);
    }

    /**
     * @param bool $all
     * @param int $perPage
     * @return array|Arrayable
     */
    public function getDetails(bool $all = false, int $perPage = 100): array|Arrayable
    {
        $states = [
            self::getListingByCode(self::IMPORT_DONE)->id,
            self::getListingByCode(self::IMPORT_FAILED)->id
        ];

        if (in_array($this->listingKeyName(), $states)) {
            return collect();
        }

        $query = $this->import_processing();

        return $all ? $query->get() : $query->paginate($perPage);
    }

    /**
     * @param RepositoryInterface|Builder|EloquentBuilder $repository
     * @return array
     * @throws Throwable
     */
    public function validate(RepositoryInterface|Builder|EloquentBuilder $repository): array
    {
        $this->setListingState(self::IMPORT_VALIDATION_PROCESSING);

        /** @var Pipeline $pipeline */
        $rules = $this->getValidationRules();
        $pipeline = app(Pipeline::class)->through([
            CsvParser::class,
            new AssociateDataToRuleFields($rules),
            new ValidateData($rules),
        ]);

        $tuples = [];

        $this->import_processing()->where("has_error", false)->get('content')
            ->lazy()->each(function (ImportProcessing $importProcessing) use (&$pipeline, &$repository, &$tuples) {
                try {
                    $data = $pipeline->send($importProcessing->content)->thenReturn();
                    $tuples[] = $repository->create($data)->toArray();
                } catch (Exception $exception) {
                    //$this->setListingState(self::IMPORT_VALIDATION_FAILED);
                }
            });

        $this->setListingState(self::IMPORT_VALIDATION_DONE);

        return $tuples;
    }

    /**
     * @throws Throwable
     */
    private function getValidationRules(): array
    {
        $file = data_get($this->payload, 'file');

        throw_if(
            !$file || !file_exists($file),
            FileNotFoundException::class,
            $file
        );

        $config = client_config(data_get($this->payload, 'config'));

        return collect(data_get($config, 'columns'))
            ->map(fn (array $column) => $column['validation'])
            ->toArray();
    }

    /**
     * @return bool
     */
    public function isValidable(): bool
    {
        return $this->getCurrentStep()->id === self::getListingByCode(self::IMPORT_DONE)->id;
    }
}
