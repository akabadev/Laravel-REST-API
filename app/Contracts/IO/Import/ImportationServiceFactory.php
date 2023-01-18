<?php

namespace App\Contracts\IO\Import;

final class ImportationServiceFactory
{
    private function __construct()
    {
        //
    }

    /**
     * @param string $service
     * @return ImportationService
     */
    public static function make(string $service = "csv"): ImportationService
    {
        return match ($service) {
            "csv" => new CsvImportationService(),
            default => new CsvImportationService()
        };
    }
}
