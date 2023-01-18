<?php

namespace App\Console;

use App\Console\Commands\MakeTemplateCommand;
use App\Console\Commands\MigrateAndSeedCommand;
use App\Console\Commands\QueuePendingProcessesCommand;
use App\Models\Tenant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MigrateAndSeedCommand::class,
        MakeTemplateCommand::class,
        QueuePendingProcessesCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        tenancy()->runForMultiple(null, function (Tenant $tenant) use ($schedule) {
            $schedule->command(QueuePendingProcessesCommand::class, [$tenant->id])
                ->everyMinute()
                ->withoutOverlapping()
                ->description("description");
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function scheduleTimezone(): string
    {
        return 'Europe/Paris';
    }
}
