<?php

namespace App\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class CustomFileLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger($config['name']);
        $level = $logger::toMonologLevel($config['level'] ?: 'debug');
        $logger->pushHandler(new StreamHandler($this->getFullPath(), $level, false));
        return $logger;
    }

    /**
     * @return string
     */
    abstract protected function getFullPath(): string;
}
