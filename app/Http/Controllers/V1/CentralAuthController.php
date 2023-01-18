<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Utils\Authenticator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CentralAuthController extends Controller
{
    use Authenticator;

    /**
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return view('application.login');
        }

        return redirect()->route('tenants.index');
    }

    /**
     * @OA\Post(
     *     path="/main/api/v1/login",
     *     summary="Sign in",
     *     description="Login by email, password",
     *     operationId="Login",
     *     tags={"central/authentication"},
     *     @OA\RequestBody(ref="#/components/requestBodies/SignInRequest"),
     *     @OA\Response(
     *        response=422,
     *        description="Wrong credentials response",
     *        @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     *
     * @param SignInRequest $request
     * @return RedirectResponse|JsonResponse
     * @throws Throwable
     */
    public function signIn(SignInRequest $request): RedirectResponse|JsonResponse
    {
        ['email' => $email, 'password' => $password] = $request->validated();
        return $this->loginInWithApi($email, $password);
    }

    /**
     * @OA\Post(
     *     path="/main/api/v1/logout",
     *     summary="Sign out",
     *     description="Logout",
     *     operationId="authlogout",
     *     tags={"central/authentication"},
     *     @OA\Response(
     *        response=200,
     *        description="Logged Out",
     *        @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="You logged out successfully")
     *        )
     *     )
     * )
     *
     * @return JsonResponse|RedirectResponse
     */
    public function signOut(): JsonResponse|RedirectResponse
    {
        return $this->logout();
    }
}
