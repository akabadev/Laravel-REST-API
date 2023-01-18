<?php

namespace App\Contracts\IO\Export;

final class ExportationServiceFactory
{
    /**
     * @param string $type
     * @return ExportationService
     */
    public static function make(string $type): ExportationService
    {
        return match ($type) {
            'csv' => app(CsvExportationService::class),
            'pdf' => app(PdfExportationService::class),
            default => app(CsvExportationService::class)
        };
    }

    /**
     * @param string $type
     * @return bool
     */
    public static function isSupported(string $type): bool
    {
        return in_array($type, ['csv', 'pdf']);
    }
}
