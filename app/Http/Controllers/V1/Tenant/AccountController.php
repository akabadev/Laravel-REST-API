<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\CentralAccountController;
use Illuminate\Http\JsonResponse;

class AccountController extends CentralAccountController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/account/menus",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"account"},
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
    public function menus(): JsonResponse
    {
        return parent::menus();
    }
}
