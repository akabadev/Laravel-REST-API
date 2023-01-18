<?php

namespace App\Contracts\IO\Export;

use App\Contracts\IO\Writable;
use App\Contracts\IO\WritableFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CsvExportationService extends ExportationService
{
    /**
     * @param string $path
     * @return Writable
     */
    public function writable(string $path): Writable
    {
        return new WritableFile(Str::finish($path, '.csv'));
    }

    /**
     * @param Writable $writable
     * @param array $data
     * @param string $columnSeparator
     * @return bool
     */
    protected function exportLine(Writable $writable, array $data, string $columnSeparator = ';'): bool
    {
        return fputcsv($writable->getResource(), Arr::flatten($data), $columnSeparator) !== false;
    }

    /**
     * @param Writable $writable
     * @param array $header
     * @param string $columnSeparator
     * @return bool
     */
    protected function exportHeader(Writable $writable, array $header, string $columnSeparator = ";"): bool
    {
        return $this->exportLine($writable, $header, $columnSeparator);
    }
}
