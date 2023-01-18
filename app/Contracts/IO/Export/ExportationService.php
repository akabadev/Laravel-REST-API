<?php

namespace App\Contracts\IO\Export;

use App\Contracts\IO\Writable;
use App\Models\Contracts\Exportable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

abstract class ExportationService
{
    /**
     * @param string $path
     * @return Writable
     */
    abstract public function writable(string $path): Writable;

    /**
     * @param Exportable|Builder|EloquentBuilder $exportables
     * @param string $to
     * @param string[] $columns
     * @param array $headers
     * @return Writable|null
     */
    public function export(Exportable|Builder|EloquentBuilder $exportables, string $to, array $columns = [], array $headers = []): ?Writable
    {
        $writable = $this->writable($to);

        $this->exportHeader($writable, $headers);

        if ($exportables instanceof Exportable) {
            $this->exportLine(
                $writable,
                Arr::onlyRecursive(
                    $exportables->exportableData(),
                    $columns
                )
            );
        } else {
            $exportables->lazy()->each(function (Exportable $exportable) use (&$writable, &$columns) {
                $this->exportLine(
                    $writable,
                    Arr::onlyRecursive(
                        $exportable->exportableData(),
                        $columns
                    )
                );
            });
        }
        return $writable;
    }

    /**
     * @param Writable $writable
     * @param array $data
     * @return bool
     */
    abstract protected function exportLine(Writable $writable, array $data): bool;

    /**
     * @param Writable $writable
     * @param array $header
     * @return bool
     */
    abstract protected function exportHeader(Writable $writable, array $header): bool;
}
