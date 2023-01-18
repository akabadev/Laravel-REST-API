<?php

namespace App\Contracts\IO;

class ReadableFile implements Readable
{
    private mixed $resource = null;

    public function __construct(private string $path, private string $mode = 'r')
    {
    }

    /**
     * @return mixed
     */
    public function getResource(): mixed
    {
        return $this->resource ?: $this->resource = fopen($this->path, $this->mode);
    }

    /**
     * @return string
     */
    public function getResourceId(): string
    {
        return $this->path;
    }
}
