<?php

namespace App\Repository\Contracts;

use App\Models\Task;

interface CanImport
{
    /**
     * @param Task $task
     * @param array $tuples
     * @param array $rules
     * @param int $line
     * @return void
     */
    public function import(Task &$task, array $tuples, array $rules = [], int $line = 1): void;
}
