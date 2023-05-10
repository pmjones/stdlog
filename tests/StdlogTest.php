<?php
declare(strict_types=1);

namespace pmjones\Stdlog;

class StdlogTest extends \PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        /** @var resource */
        $stdout = fopen('php://memory', 'w+');

        /** @var resource */
        $stderr = fopen('php://memory', 'w+');

        $log = new Stdlog($stdout, $stderr);

        $context = ['name' => 'world'];
        $log->info("Hello {name}", $context);
        $log->error("Error {name}", $context);

        $this->assertOutput($stdout, 'Hello world' . PHP_EOL);
        $this->assertOutput($stderr, 'Error world' . PHP_EOL);
    }

    /**
     * @param resource $stream
     */
    public function assertOutput(mixed $stream, string $expect) : void
    {
        rewind($stream);
        $actual = '';

        while (! feof($stream)) {
            $actual .= fread($stream, 8192);
        }

        $this->assertSame($expect, $actual);
    }
}
