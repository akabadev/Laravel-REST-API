<?php

namespace App\Contracts\IO\Import;

use App\Contracts\IO\Readable;
use App\Contracts\IO\ReadableFile;

class CsvImportationService extends ImportationService
{
    /**
     * @param string $path
     * @return Readable
     */
    public function readable(string $path): Readable
    {
        return new ReadableFile($path);
    }
}
