<?php

namespace App\Http\Utils;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

trait Authenticator
{
    /**
     * @param string $email
     * @param string $password
     * @return JsonResponse
     * @throws Throwable
     */
    public function loginInWithApi(string $email, string $password): JsonResponse
    {
        $authenticated = Auth::attempt(compact('email', 'password'));

        throw_unless($authenticated, new AuthenticationException('Wrong Credentials'));

        /** @var User $user */
        $user = User::where('email', $email)->firstOrFail();

        $user->tokens()->delete();

        $token = $user->createToken(PersonalAccessToken::MAIN_APP_TOKEN_NAME)->plainTextToken;

        Auth::login($user);

        return $this->successResponse(compact('user', 'token'));
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $routeOnSuccess
     * @return RedirectResponse
     */
    public function loginInWithForm(string $email, string $password, $routeOnSuccess = 'tenants.index'): RedirectResponse
    {
        $authenticated = Auth::attempt(compact('email', 'password'));

        if (!$authenticated) {
            return redirect()
                ->back()
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->with(['message' => 'Incorrect Credentials']);
        }

        return redirect()
            ->route($routeOnSuccess)
            ->with(['message' => 'Welcome to Logiweb']);
    }

    /**
     * @param string $routeOnSuccess
     * @return JsonResponse|RedirectResponse
     */
    public function logout(string $routeOnSuccess = 'sign-in-form'): JsonResponse|RedirectResponse
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            Auth::guard('web')->logout();
        }

        return request()->expectsJson() ?
            $this->successResponse(message: "You're Logged Out successfully") :
            redirect()->route($routeOnSuccess);
    }
}
