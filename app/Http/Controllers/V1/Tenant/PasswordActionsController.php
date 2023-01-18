<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\CentralPasswordActionsController;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Requests\Account\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

class PasswordActionsController extends CentralPasswordActionsController
{
    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/account/password/forgot",
     *     summary="Request password change",
     *     description="Request password change",
     *     tags={"account"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
        return parent::changePassword($request);
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/account/password/update",
     *     summary="Update password",
     *     description="Update password",
     *     tags={"account"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
        return parent::updatePassword($request);
    }
}
