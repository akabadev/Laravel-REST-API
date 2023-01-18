<?php

namespace App\Contracts\IO;

use Illuminate\Support\Facades\File;

class WritableFile implements Writable
{
    private mixed $resource = null;

    public function __construct(private string $path, private string $mode = 'w+')
    {
    }

    /**
     * @return mixed
     */
    public function getResource(): mixed
    {
        if ($this->resource == null) {
            File::ensureDirectoryExists(dirname($this->path));
            $this->resource = fopen($this->path, $this->mode);
        }
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getResourceId(): string
    {
        return $this->path;
    }

    /**
     * @param string $line
     * @param string $end
     * @return false|int
     */
    public function writeLine(string $line, string $end = "\n"): bool|int
    {
        return File::append($this->path, $line . $end);
    }

    public function close()
    {
        if ($this->resource) {
            fclose($this->resource);
        }
    }
}
