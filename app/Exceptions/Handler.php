<?php

namespace App\Exceptions;

use App\Logging\Log;
use CompileError;
use Error;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use RuntimeException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'token',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Exception $exception) {
            return Fail::from($exception, false)->render(request());
        });
    }

    /**
     * @param Throwable $e
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        if (env("ENABLE_RUNTIME_ERROR_LOGGER") &&
            ($e instanceof RuntimeException || $e instanceof CompileError || $e instanceof Error)) {
            Log::runtimeError(
                $e->getMessage(),
                array_merge(
                    $this->exceptionContext($e),
                    $this->context(),
                    ['exception' => $e]
                )
            );
            return;
        }

        parent::report($e);
    }
}
