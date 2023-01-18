<?php


namespace App\Contracts\IO;

interface Readable
{
    /**
     * @return mixed
     */
    public function getResource(): mixed;

    /**
     * @return string
     */
    public function getResourceId(): string;
}
