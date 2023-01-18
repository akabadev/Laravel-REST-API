<?php

namespace App\Repository\Concerns;

use App\Contracts\IO\Import\Pipes\AssociateDataToRuleFields;
use App\Contracts\IO\Import\Pipes\CsvParser;
use App\Contracts\IO\Import\Pipes\ValidateData;
use App\Models\ImportProcessing;
use App\Models\Task;
use Exception;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Validation\ValidationException;

trait CanImport
{
    /**
     * @param Task $task
     * @param array $tuples
     * @param array $rules
     * @param int $line
     */
    public function import(Task &$task, array $tuples, array $rules = [], int $line = 1): void
    {
        /** @var Pipeline $pipeline */
        $pipeline = app(Pipeline::class)->through([
            CsvParser::class,
            new AssociateDataToRuleFields($rules),
            new ValidateData($rules),
        ]);

        collect($tuples)->each(function (string $tuple) use (&$task, &$pipeline, &$line) {
            $importProcess = ImportProcessing::init($task, $line, $tuple);

            try {
                $pipeline->send($tuple)->thenReturn();
            } catch (ValidationException $validationException) {
                $importProcess->update([
                    'has_error' => true,
                    'errors' => $validationException->errors(),
                    'message' => 'Données non valides'
                ]);
                $task->failed();
            } catch (Exception $exception) {
                $importProcess->update([
                    'has_error' => true,
                    'errors' => ['une erreur est survenue'],
                    'message' => $exception->getMessage()
                ]);
                $task->failed();
            }

            $line++;
        });
    }
}
