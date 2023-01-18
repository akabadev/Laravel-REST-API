<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final class Fail
{
    private function __construct()
    {
    }

    private array $exceptions = [

    ];

    /**
     * @param Exception $exception
     * @param bool $throws
     * @return RenderableException
     * @throws Throwable
     */
    public static function from(Exception $exception, bool $throws = true): RenderableException
    {
        if ($exception instanceof RenderableException) {
            throw_if($throws, $exception);
            return $exception;
        }

        $matchs = self::match($exception);

        $matchs['statusCode'] = $matchs['statusCode'] ?? __('errors.default_status_code') ?? Response::HTTP_BAD_REQUEST;
        $matchs['code'] = $matchs['code'] ?? __('errors.default_code') ?? Response::HTTP_BAD_REQUEST;
        $matchs['message'] = $matchs['message'] ?? __('errors.default_message') ?? 'An error occurred';
        $matchs['errors'] = $matchs['errors'] ?? []; // ?? __('errors.default_errors') ?? [];

        [
            "statusCode" => $statusCode,
            "code" => $code,
            "message" => $message,
            "errors" => $errors
        ] = $matchs;

        $exception = new RenderableException(intval($statusCode), __($message), $errors, [], $code);

        throw_if($throws, $exception);

        return $exception;
    }

    /**
     * @param string $code
     * @param string|null $message
     * @param array $data
     * @param array $headers
     */
    public static function authorizationIssue(string $code, ?string $message = null, array $data = [], array $headers = [])
    {
        throw new RenderableException(Response::HTTP_UNAUTHORIZED, $message, $data, $headers, $code);
    }

    /**
     * @param string $code
     * @param string|null $message
     * @param array $errors
     * @param array $headers
     */
    public static function validationIssue(string $code, ?string $message = null, array $errors = [], array $headers = [])
    {
        throw new RenderableException(Response::HTTP_UNPROCESSABLE_ENTITY, $message, $errors, $headers, $code);
    }

    /**
     * @param string $code
     * @param array $data
     * @param array $headers
     */
    public static function serverIssue(string $code, array $data = [], array $headers = [])
    {
        throw new RenderableException(Response::HTTP_UNPROCESSABLE_ENTITY, "errors.server", $data, $headers, $code);
    }

    /**
     * @param string $code
     * @param int $statusCode
     * @param string|null $message
     * @param array $data
     * @param array $headers
     */
    public static function with(string $code, int $statusCode = Response::HTTP_BAD_REQUEST, ?string $message = null, array $data = [], array $headers = [])
    {
        throw new RenderableException($statusCode, $message, $data, $headers, $code);
    }

    /**
     * @param Exception $exception
     * @return array
     */
    private static function match(Exception $exception): array
    {
        $code = $statusCode = $exception->getCode();
        $message = $exception->getMessage();
        $errors = [];

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
        } elseif ($exception instanceof ValidationException) {
            $errors = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } elseif (property_exists($exception, 'status')) {
            $statusCode = $exception->status;
        } elseif (method_exists($exception, "getStatusCode")) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        $code = intval($code) == 0 ? $statusCode : $code;

        $message = strlen($message) > 0 ? $message : __("errors.$code") ?? __("errors.$statusCode");

        return compact("code", "message", "statusCode", "errors");
    }
}
