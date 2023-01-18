<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppQueueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::before(function (JobProcessing $event) {
            // optional($event->job->process)->update(['process_status' => ProcessStatus::PROGRESS_STATUS_ID]);
        });

        Queue::after(function (JobProcessed $event) {
            // optional($event->job->process)->update(['process_status' => ProcessStatus::SUCCESS_STATUS_ID]);
        });

        Queue::exceptionOccurred(function (JobExceptionOccurred $event) {
            // optional($event->job->process)->update(['process_status' => ProcessStatus::FAILURE_STATUS_ID]);
        });

        Queue::failing(function (JobFailed $event) {
            //optional($event->job->process)->update(['process_status' => ProcessStatus::FAILURE_STATUS_ID]);
        });
    }
}
