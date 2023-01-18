<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use Illuminate\Http\JsonResponse;

class SettingController extends BaseController
{

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/settings",
     *     summary="Current Tenant Setting",
     *     description="Current Tenant Setting",
     *     tags={"settings"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->successResponse(param());
    }
}
