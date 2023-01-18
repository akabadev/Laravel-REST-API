<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\Menu\CreateMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class CentralMenuController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/menus",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/menus"},
     *     @OA\Parameter(ref="#/components/parameters/profile"),
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Menu")),
     *              @OA\Property(property="current_page", type="integer"),
     *              @OA\Property(property="to", type="integer"),
     *              @OA\Property(property="total", type="integer"),
     *              @OA\Property(property="path", type="string"),
     *              @OA\Property(property="next_page_url", type="string"),
     *              @OA\Property(property="prev_page_url", type="string")
     *          )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(Menu::paginate());
    }

    /**
     * @OA\Post (
     *     path="/main/api/v1/menus",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/menus"},
     *     @OA\Parameter(ref="#/components/parameters/profile"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateMenuRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateMenuRequest $request
     * @return JsonResponse
     */
    public function store(CreateMenuRequest $request): JsonResponse
    {
        $menu = Menu::updateOrCreate(
            Arr::only($request->validated(), ['profile_id', 'view_id']),
            Arr::except($request->validated(), ['profile_id', 'view_id'])
        );

        return $this->successResponse($menu);
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/menus/{menu}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"central/menus"},
     *     @OA\Parameter(ref="#/components/parameters/profile"),
     *     @OA\Parameter(ref="#/components/parameters/menu"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateMenuRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Menu $menu
     * @return JsonResponse
     */
    public function show(Menu $menu): JsonResponse
    {
        return $this->successResponse($menu);
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/menus/{menu}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/menus"},
     *     @OA\Parameter(ref="#/components/parameters/profile"),
     *     @OA\Parameter(ref="#/components/parameters/menu"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateMenuRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/main/api/v1/menus/{menu}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/menus"},
     *     @OA\Parameter(ref="#/components/parameters/profile"),
     *     @OA\Parameter(ref="#/components/parameters/menu"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateMenuRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateMenuRequest $request
     * @param Menu $menu
     * @return JsonResponse
     */
    public function update(UpdateMenuRequest $request, Menu $menu): JsonResponse
    {
        return $this->successResponse($menu->update($request->validated()));
    }

    /**
     * @OA\Delete (
     *     path="/main/api/v1/menus/{menu}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/menus"},
     *     @OA\Parameter(ref="#/components/parameters/profile"),
     *     @OA\Parameter(ref="#/components/parameters/menu"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Menu $menu
     * @return JsonResponse
     */
    public function destroy(Menu $menu): JsonResponse
    {
        return $this->successResponse($menu->delete());
    }
}
