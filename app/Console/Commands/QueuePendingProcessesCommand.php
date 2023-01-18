<?php

namespace App\Console\Commands;

use App\Models\Process;
use App\Models\Task;
use Illuminate\Console\Command;
use ReflectionException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;

class QueuePendingProcessesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:queue-processes {tenant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue Pending Processes';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws TenantCouldNotBeIdentifiedById|ReflectionException
     */
    public function handle(): int
    {
        tenancy()->initialize($this->argument('tenant'));

        Process::all()->map->pendingTasks()->map->get()->flatten()
            ->each(function (Task $task) {
                $this->warn("<info>🤖 | Queueing task:</info> $task->comment");
                $task->concrete()->queue();
                $this->info("✅ | Task Queued.\n");
            });

        return self::SUCCESS;
    }
}
