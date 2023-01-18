<?php

namespace App\Contracts\IO;

interface Writable extends Readable
{
    public function writeLine(string $line, string $end = "\n"): bool|int;
}
