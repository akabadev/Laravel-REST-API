<?php

namespace App\Contracts\IO\Export;

use App\Contracts\IO\Writable;
use App\Contracts\IO\WritableFile;
use App\Models\Contracts\Exportable;
use Barryvdh\DomPDF\Facade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PdfExportationService extends ExportationService
{
    /**
     * @param string $path
     * @return Writable
     */
    public function writable(string $path): Writable
    {
        return new WritableFile(Str::finish($path, '.pdf'));
    }

    /**
     * @param Exportable|Builder|\Illuminate\Database\Query\Builder $exportables
     * @param string $to
     * @param array $columns
     * @param array $headers
     * @return Writable|null
     */
    public function export(Exportable|Builder|\Illuminate\Database\Query\Builder $exportables, string $to, array $columns = [], array $headers = []): ?Writable
    {
        $tuples = [];

        if ($exportables instanceof Exportable) {
            $tuples[] = Arr::onlyRecursive($exportables->exportableData(), $columns);
        } else {
            $exportables->lazy()->each(function (Exportable $exportable) use (&$writable, &$columns, &$tuples) {
                $tuples[] = array_map(
                    fn ($value) => is_array($value) ? implode(',', $value) : $value,
                    Arr::onlyRecursive($exportable->exportableData(), $columns)
                );
            });
        }

        Facade::loadView(
            'exports.viewables',
            compact('tuples', 'headers', 'columns')
        )->setPaper('a4', 'landscape')->setWarnings(false)->save(Str::finish($to, ".pdf"));

        return null;
    }

    /**
     * @param Writable $writable
     * @param array $data
     * @return bool
     */
    protected function exportLine(Writable $writable, array $data): bool
    {
        return false;
    }

    /**
     * @param Writable $writable
     * @param array $header
     * @return bool
     */
    protected function exportHeader(Writable $writable, array $header): bool
    {
        return false;
    }
}
