<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends BaseController
{
    const MAX_USER_TOKENS = 3;

    /**
     * @OA\Post(
     *     path="/{tenant}/api/v1/login",
     *     summary="Sign in",
     *     description="Login by email, password",
     *     operationId="authLogin",
     *     tags={"authentication"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/LoginRequest"),
     *     @OA\Response(
     *        response=422,
     *        description="Wrong credentials response",
     *        @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $method = param('authentication.by');
        $data = $request->validated();

        $authenticated = Auth::attempt($data);

        throw_unless($authenticated, new AuthenticationException("Wrong Credentials"));

        /** @var User $user */
        $user = User::where($method, $data[$method])->firstOrFail();

        if ($user->tokens()->count() > self::MAX_USER_TOKENS) {
            $user->tokens()->latest()->skip(self::MAX_USER_TOKENS)->delete();
        }

        $token = $user->createToken(PersonalAccessToken::TENANT_APP_TOKEN_NAME)->plainTextToken;

        Auth::login($user);

        return $this->successResponse(compact("user", "token"), "Welcome !");
    }

    /**
     * @OA\Post(
     *     path="/{tenant}/api/v1/logout",
     *     summary="Sign out",
     *     description="Logout",
     *     operationId="logout",
     *     tags={"authentication"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(
     *        response=200,
     *        description="Logged Out",
     *        @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="You logged out successfully")
     *        )
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->user()->currentAccessToken()->delete();

        // Auth::logout();

        return $this->successResponse(message: "You logged out successfully");
    }
}
