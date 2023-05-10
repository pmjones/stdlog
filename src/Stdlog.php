<?php
declare(strict_types=1);

namespace pmjones\Stdlog;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Stringable;

class Stdlog extends AbstractLogger
{
    public const LOG_TO_STDERR = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::DEBUG,
    ];

    /**
     * @param resource $stdout
     * @param resource $stderr
     */
    public function __construct(
        protected mixed $stdout = STDOUT,
        protected mixed $stderr = STDERR,
    ) {
        $this->stdout = $stdout;
        $this->stderr = $stderr;
    }

    /**
     * @param mixed $level
     * @param string[] $context
     */
    public function log(
        $level,
        string|Stringable $message,
        array $context = []
    ) : void
    {
        $replace = [];

        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        $message = strtr((string) $message, $replace) . PHP_EOL;
        $handle = $this->stdout;

        if (in_array($level, static::LOG_TO_STDERR)) {
            $handle = $this->stderr;
        }

        fwrite($handle, $message);
    }
}
