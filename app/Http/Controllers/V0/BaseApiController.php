<?php


namespace App\Http\Controllers\V0;

use App\Http\Controllers\Controller;
use App\Http\Utils\ForwardLogiwebApiCallTrait;
use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class BaseApiController
 * @package App\Http\Controllers\V0
 * @deprecated
 */
abstract class BaseApiController extends Controller
{
    use ForwardLogiwebApiCallTrait;

    /**
     * Display a listing of the resource from the API..
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function index(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'Show');
    }

    /**
     * Display a given resource from the API..
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function show(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'Show');
    }

    abstract protected function getLogiwebResourceClass(): string;

    /**
     * Store a newly created resource on the API.
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function store(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall($this->getLogiwebResourceClass(), 'Add');
    }

    /**
     * Update the specified resource on the API.
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function update(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall($this->getLogiwebResourceClass(), 'Update');
    }

    /**
     * Remove the specified resource from the API.
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function destroy(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardDeleteCall($this->getLogiwebResourceClass(), 'Delete');
    }

    /**
     * Export the specified resource from the API.
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function export(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardHttpRequest($this->getLogiwebResourceClass(), 'Export');
    }

    /**
     * Import resource from the API.
     *
     * @return Response|JsonResponse|GuzzleResponse
     * @throws Throwable
     */
    public function import(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardHttpRequest($this->getLogiwebResourceClass(), 'Import', request()->all(), 'post');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function importsFormat(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardHttpRequest($this->getLogiwebResourceClass(), 'GetFormat');
    }
}
