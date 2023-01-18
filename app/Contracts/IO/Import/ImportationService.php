<?php

namespace App\Contracts\IO\Import;

use App\Contracts\IO\Readable;
use App\Models\Task;
use App\Repository\Contracts\CanImport;
use Illuminate\Support\LazyCollection;

abstract class ImportationService
{
    /**
     * @param string $path
     * @return Readable
     */
    abstract public function readable(string $path): Readable;

    /**
     * @param Task $task
     * @param LazyCollection $importable
     * @param CanImport $canImport
     * @param array $rules
     * @return void
     */
    public function import(Task &$task, LazyCollection $importable, CanImport $canImport, array $rules = []): void
    {
        $chunk = 100;
        $line = 0;
        $importable->chunk($chunk)
            ->each(function (LazyCollection $lines) use (&$task, &$canImport, &$rules, &$chunk, &$line) {
                $canImport->import($task, $lines->toArray(), $rules, $chunk * $line + 1);
                $line++;
            });
    }
}
