<?php

namespace App\Jobs;

use App\Logging\Log;
use App\Models\Process;
use App\Models\Task;
use App\Models\Tenant;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\QueueManager;
use Illuminate\Queue\SerializesModels;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;
use Throwable;

abstract class Job implements ShouldQueue, ShouldBeUnique, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var QueueManager|string|null */
    public $queue;

    private ?Process $process;

    public array $payload = [];

    protected function __construct(protected Tenant $tenant, protected ?Task $task)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws TenantCouldNotBeIdentifiedById
     */
    final public function handle()
    {
        $this->task = $this->task->concrete();
        $this->task->start();
        try {
            $before = tenant();

            if ($this->tenant) {
                tenancy()->initialize($this->tenant);
                $this->handleOnTenancyContext();
            }

            tenancy()->end();

            $this->handleOnCentralContext();

            if ($before) {
                tenancy()->initialize($before);
            }
        } catch (Exception $exception) {
            Log::task($exception->getMessage(), [$this->task, $exception]);
            throw $exception;
        } finally {
            $this->task->end();
        }
    }

    public function middleware()
    {
        return [
            new WithoutOverlapping("LOGIWEB"),
            new ThrottlesExceptions(10, 5)
        ];
    }

    protected function setPayload(array $taskPayload)
    {
        $this->payload = $taskPayload;
    }

    /**
     * @param Task $task
     * @return static
     */
    abstract public static function instance(Task $task): static;

    abstract protected function handleOnTenancyContext(): void;

    abstract protected function handleOnCentralContext(): void;

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $this->task->failed();
        Log::task($exception->getMessage(), [$this->tenant, $this->task, $exception]);
    }
}
