<?php

namespace App\Jobs;

use App\Logging\Log;
use App\Models\Contracts\CanBeValidated;
use App\Models\Task;
use Exception;

class ValidateImportJob extends Job
{
    /**
     * @param Task|CanBeValidated $task
     * @return static
     */
    public static function instance(Task|CanBeValidated $task): static
    {
        return new static(tenant(), $task);
    }

    protected function handleOnTenancyContext(): void
    {
        if ($this->task instanceof CanBeValidated && $this->task->isValidable()) {
            try {
                $this->task->validate(app($this->task->payload['repository']));
            } catch (Exception $exception) {
                Log::task($exception->getMessage(), [$this->task, $exception]);
            }
        }
    }

    protected function handleOnCentralContext(): void
    {
    }
}
