<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Requests\Account\UpdatePasswordRequest;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Notifications\RequestUpdateUserPassword;
use App\Notifications\UserPasswordUpdated;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class CentralPasswordActionsController extends Controller
{
    /**
     * @OA\Post (
     *     path="/main/api/v1/account/password/forgot",
     *     summary="Request password change",
     *     description="Request password change",
     *     tags={"central/account"},
     *     @OA\RequestBody(ref="#/components/requestBodies/ChangePasswordRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        ["email" => $email] = $request->validated();

        /** @var User $user */
        $user = User::query()->where("email", $email)->firstOrFail();

        $token = $user->createToken(PersonalAccessToken::GENERATED_TOKEN_NAME, ["change-password"]);

        $user->notify((new RequestUpdateUserPassword($token))->delay(now()->addMinutes(2)));

        return $this->successResponse(message: "Email is being sent");
    }

    /**
     * @OA\Post (
     *     path="/main/api/v1/account/password/update",
     *     summary="Update password",
     *     description="Update password",
     *     tags={"central/account"},
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePasswordRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        ["password" => $password] = $request->validated();
        $password = Hash::make($password);

        $this->user()->update(compact("password"));
        $this->user()->tokens()->delete();

        Notification::send(
            $this->user(),
            (new UserPasswordUpdated())
                ->delay(now()->addMinutes())
                ->onQueue("password")
        );

        return $this->successResponse(message: "Password updated successfully");
    }
}
