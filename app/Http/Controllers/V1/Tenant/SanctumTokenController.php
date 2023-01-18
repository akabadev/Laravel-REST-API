<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\CentralSanctumTokenController;
use App\Http\Requests\Token\CreateTokenRequest;
use App\Http\Requests\Token\UpdateTokenRequest;
use App\Models\PersonalAccessToken;
use Illuminate\Http\JsonResponse;

class SanctumTokenController extends CentralSanctumTokenController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/tokens",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"tokens"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *              @OA\Property(property="current_page", type="integer"),
     *              @OA\Property(property="to", type="integer"),
     *              @OA\Property(property="total", type="integer"),
     *              @OA\Property(property="path", type="string"),
     *              @OA\Property(property="next_page_url", type="string"),
     *              @OA\Property(property="prev_page_url", type="string"),
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
        return parent::index();
    }

    /**
     * @OA\Post  (
     *     path="/{tenant}/api/v1/tokens",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"tokens"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateTokenRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateTokenRequest $request
     * @return JsonResponse
     */
    public function store(CreateTokenRequest $request): JsonResponse
    {
        return parent::store($request);
    }

    /**
     * Display the specified resource.
     * @OA\Get  (
     *     path="/{tenant}/api/v1/tokens/{token}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"tokens"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function show(PersonalAccessToken $token): JsonResponse
    {
        return parent::show($token);
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/tokens/{token}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"tokens"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTokenRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/tokens/{token}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"tokens"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTokenRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateTokenRequest $request
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function update(UpdateTokenRequest $request, PersonalAccessToken $token): JsonResponse
    {
        return parent::update($request, $token);
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/tokens/{token}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"tokens"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function destroy(PersonalAccessToken $token): JsonResponse
    {
        return parent::destroy($token);
    }
}
