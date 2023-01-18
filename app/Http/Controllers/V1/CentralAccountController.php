<?php

namespace App\Http\Controllers\V1;

use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class CentralAccountController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/account/menus",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/account"},
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
        $menus = $this->user()->profile
            ->menus()->root()->get()
            ->map(fn (Menu $menu) => $menu->build())
            ->values()->toArray();

        return $this->successResponse($menus, "Votre menu");
    }
}
