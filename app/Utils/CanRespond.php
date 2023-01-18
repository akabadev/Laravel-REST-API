<?php

namespace App\Utils;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait CanRespond
{
    /**
     * @param mixed $data
     * @param string|null $message
     * @param string $code
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function successResponse(mixed $data = [], ?string $message = "", string $code = "DEFAULT", int $status = Response::HTTP_OK, array $headers = [], int $options = 0): JsonResponse
    {
        $success = true;
        $data = is_bool($data) ? [] : $this->format($data);

        return response()->json(
            compact("data", "message", "success"),
            $status,
            $headers,
            $options,
            JSON_PRETTY_PRINT
        );
    }

    /**
     * @param mixed $errors
     * @param string|null $message
     * @param string $code
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public function errorResponse(mixed $errors = [], ?string $message = '', string $code = 'DEFAULT', int $status = Response::HTTP_OK, array $headers = [], int $options = 0): JsonResponse
    {
        $success = false;
        return response()->json(
            compact('message', 'code', 'errors', 'success'),
            $status,
            $headers,
            $options
        );
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    private function format(mixed $data): mixed
    {
        if ($data instanceof Arrayable) {
            $data = $this->arrayableAdapter($data);
        }

        return $data;
    }

    /**
     * @param Arrayable $data
     * @return array
     */
    private function arrayableAdapter(Arrayable $data): array
    {
        if ($data instanceof Model) {
            return ["data" => $data->toArray()];
        }
        return $data->toArray();
    }
}
