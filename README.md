# Stdlog

Use this [psr/log](https://packagist.org/packages/psr/log) implementation for
logging output to `STDOUT` and `STDERR`.

Great for logging to console output ...

```php
use pmjones\Stdlog\Stdlog;

$log = new Stdlog();

// info level logs to STDOUT
$log->info('Hello world!');

// all other levels log to STDERR
$log->error('Other world!');
```

... or to streams:

```php
use pmjones\Stdlog\Stdlog;

$log = new Stdlog(
    stdout: fopen('php://memory', 'w'),
    stderr: fopen('php://memory', 'w')
);

// info level logs to STDOUT
$log->info('Hello world!');

// all other levels log to STDERR
$log->error('Other world!');
```
