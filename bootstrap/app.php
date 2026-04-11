<?php

// Load intl override first
require_once __DIR__ . '/intl-override.php';

// Sanitize all environment variables - remove CR/LF/TAB characters
// This fixes "Invalid URI: A URI cannot contain CR/LF/TAB characters" on Railway
foreach ($_ENV as $key => $value) {
    if (is_string($value)) {
        $_ENV[$key] = str_replace(["\r", "\n", "\t"], '', $value);
        putenv($key . '=' . $_ENV[$key]);
    }
}
foreach ($_SERVER as $key => $value) {
    if (is_string($value) && strpos($key, 'HTTP_') === false) {
        $_SERVER[$key] = str_replace(["\r", "\n", "\t"], '', $value);
    }
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
