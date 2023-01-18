<?php

namespace App\Models\Concerns;

use App\Contracts\IO\Import\Pipes\AssociateDataToRuleFields;
use App\Contracts\IO\Import\Pipes\CsvParser;
use App\Contracts\IO\Import\Pipes\ValidateData;
use App\Repository\Contracts\Interfaces\RepositoryInterface;
use Exception;
use Illuminate\Pipeline\Pipeline;

trait TaskValidator
{
    /**
     * @param RepositoryInterface $repository
     * @param array $rules
     * @return array
     */
    public function validateTask(RepositoryInterface $repository, array $rules = []): array
    {
        /** @var Pipeline $pipeline */
        $pipeline = app(Pipeline::class)
            ->through([
                CsvParser::class,
                new AssociateDataToRuleFields($rules),
                new ValidateData($rules),
            ]);

        $tuples = [];

        $this->import_processing()->where('has_error', false)->get('content')
            ->lazy()->each(function (ImportProcessing $importProcessing) use (&$pipeline, &$repository, &$tuples) {
                try {
                    $data = $pipeline->send($importProcessing->content)->thenReturn();
                    $tuples[] = $repository->create($data)->toArray();
                } catch (Exception $exception) {
                    //$this->setListingState(self::IMPORT_VALIDATION_FAILED);
                }
            });

        return $tuples;
    }
}
