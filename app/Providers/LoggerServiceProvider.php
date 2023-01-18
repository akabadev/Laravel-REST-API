<?php

namespace App\Providers;

use App\Logging\SqlQueryLogger;
use App\Logging\TaskLogger;
use App\Models\Task;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (env('ENABLE_SQL_LOGGER', false)) {
            $this->registerSqlLogger();
        }

        if (env('ENABLE_TASKS_LOGGER', false)) {
            // $this->registerTasksLogger();
        }

        if (env('ENABLE_RUNTIME_ERROR_LOGGER', false)) {
            $this->registerRuntimeLogger();
        }
    }

    private function registerSqlLogger(): void
    {
        DB::listen(fn (QueryExecuted $query) => Log::channel(SqlQueryLogger::name)->info(
            json_encode(Auth::user() ? Auth::user()->toArray() : []),
            [$query->sql, $query->bindings]
        ));
    }

    private function registerTasksLogger(): void
    {
        $callback = fn ($message) => fn (Task $task) => Log::channel(TaskLogger::name)->info($message, $task->toArray());

        Task::creating($callback("creating"));
        Task::created($callback("created"));

        Task::updating($callback("updating"));
        Task::updated($callback("updated"));

        Task::deleting($callback("deleting"));
        Task::deleted($callback("deleted"));
    }

    private function registerRuntimeLogger(): void
    {
        //
    }
}
