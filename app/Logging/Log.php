<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log as LogFacade;

final class Log
{
    /**
     * @param $message
     * @param array $context
     */
    public static function runtimeError($message, array $context = array())
    {
        LogFacade::channel(RuntimeErrorLogger::name)->error($message, $context);
    }

    /**
     * @param $message
     * @param array $context
     */
    public static function task($message, array $context = array())
    {
        LogFacade::channel(TaskLogger::name)->error($message, $context);
    }
}
