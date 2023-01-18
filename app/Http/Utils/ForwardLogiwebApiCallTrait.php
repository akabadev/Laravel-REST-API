<?php

namespace App\Http\Utils;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

trait ForwardLogiwebApiCallTrait
{
    /**
     * @param string|null $class
     * @param string|null $action
     * @return JsonResponse|Response|GuzzleResponse
     */
    protected function forwardGetCall(?string $class, ?string $action): GuzzleResponse|JsonResponse|Response
    {
        $response = Http::asForm()
            ->acceptJson()
            ->get($this->generateApiUrl($class, $action));

        return $this->formatGuzzleResponse($response);
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @return string
     */
    private function generateApiUrl(?string $class = null, ?string $action = null): string
    {
        $extranet = request()->route('extranet');

        $url = Str::finish(env('LOGIWEB_API_URL', 'http://localhost/logiweb'), '/');

        return $url . $extranet . '/' . $this->targetFile() . '?' . Arr::query($this->getParams($class, $action));
    }

    /**
     * @return string
     */
    protected function targetFile(): string
    {
        return 'ajax.php';
    }

    /**
     * @param GuzzleResponse $response
     * @return JsonResponse
     */
    private function formatGuzzleResponse(GuzzleResponse $response): JsonResponse
    {
        return response()->json($response->json());
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @return JsonResponse|Response|GuzzleResponse
     * @throws Throwable
     */
    protected function forwardPostCall(?string $class, ?string $action): GuzzleResponse|JsonResponse|Response
    {
        $response = Http::acceptJson()
            ->asForm()
            ->post($this->generateApiUrl($class, $action), request()->all());

        return $this->formatGuzzleResponse($response);
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @return JsonResponse|Response|GuzzleResponse
     * @throws Throwable
     */
    protected function forwardPutCall(?string $class, ?string $action): GuzzleResponse|JsonResponse|Response
    {
        $response = Http::asForm()
            ->acceptJson()
            ->put($this->generateApiUrl($class, $action), request()->all());

        return $this->formatGuzzleResponse($response);
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @return JsonResponse|Response|GuzzleResponse
     * @throws Throwable
     */
    protected function forwardPatchCall(?string $class, ?string $action): GuzzleResponse|JsonResponse|Response
    {
        $response = Http::asForm()
            ->acceptJson()
            ->patch($this->generateApiUrl($class, $action), request()->all());

        return $this->formatGuzzleResponse($response);
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @return JsonResponse|Response|GuzzleResponse
     * @throws Throwable
     */
    protected function forwardDeleteCall(?string $class, ?string $action): GuzzleResponse|JsonResponse|Response
    {
        $response = Http::asForm()
            ->acceptJson()
            ->delete($this->generateApiUrl($class, $action), request()->all());

        return $this->formatGuzzleResponse($response);
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @param array $data
     * @param string $method
     * @return GuzzleResponse|JsonResponse|Response
     */
    protected function forwardHttpRequest(?string $class = null, ?string $action = null, $data = [], $method = 'get'): GuzzleResponse|JsonResponse|Response
    {
        $data = 'get' === $method ? $this->getParams($class, $action) : array_merge(request()->all(), $data);
        return Http::asForm()
            ->{$method}($this->generateApiUrl($class, $action), $data);
    }

    /**
     * @param string|null $class
     * @param string|null $action
     * @return array
     */
    private function getParams(?string $class, ?string $action): array
    {
        return Arr::where(
            array_merge(
                request()->query(),
                [
                    '_key' => request()->bearerToken(),
                    'cls' => $class,
                    'act' => $action
                ],
            ),
            fn ($value) => !!$value
        );
    }
}
