<?php

namespace App\Http\Controllers\V0;

use App\Http\Controllers\Controller;
use App\Http\Utils\ForwardLogiwebApiCallTrait;
use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class AuthenticationController extends Controller
{
    use ForwardLogiwebApiCallTrait;

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function login(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall('S_UTILISATEURS', 'Connect');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     *
     */
    public function logout(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall('S_UTILISATEURS', 'Disconnect');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function verifyKey()
    {
        return $this->forwardGetCall('S_UTILISATEURS', 'VerifyKey');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function profile(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall('S_UTILISATEURS', 'GetProfils');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function messages(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(null, 'GetMessages');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function menu(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(null, 'GetMenu');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function sessionToken(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall('S_UTILISATEURS', 'getSessionToken');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function publicToken(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall('S_UTILISATEURS', 'getPublicToken');
    }
}
