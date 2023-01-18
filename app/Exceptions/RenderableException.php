<?php

namespace App\Exceptions;

use App\Utils\CanRespond;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RenderableException extends HttpException
{
    use CanRespond;

    private array $moreData;

    /**
     * RenderableException constructor.
     * @param int $statusCode
     * @param string|null $message
     * @param array $data
     * @param array $headers
     * @param int|string|null $code
     */
    public function __construct(int $statusCode, ?string $message = '', array $data = [], array $headers = [], int|string|null $code = 0)
    {
        $this->moreData = $data;
        parent::__construct($statusCode, $message, null, $headers, intval($code));
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report(): ?bool
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return $this->errorResponse($this->moreData, $this->getMessage(), $this->getCode(), $this->getStatusCode());
    }
}
