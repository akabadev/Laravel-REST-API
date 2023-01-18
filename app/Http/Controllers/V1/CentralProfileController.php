<?php

namespace App\Http\Controllers\V1;

use App\Models\Profile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CentralProfileController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/profiles",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/profiles"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Profile")),
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
        return $this->successResponse(Profile::paginate());
    }

    /**
     * @OA\Post  (
     *     path="/main/api/v1/profiles",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/profiles"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(
     *         description="New profile Data",
     *         required=false,
     *         @OA\MediaType(mediaType="application/json"),
     *         required=true
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->successResponse(Profile::create($request->all()));
    }

    /**
     * @OA\Get  (
     *     path="/main/api/v1/profiles/{profile}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"central/profiles"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Profile $profile
     * @return JsonResponse
     */
    public function show(Profile $profile): JsonResponse
    {
        return $this->successResponse($profile);
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/profiles/{profile}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/profiles"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/main/api/v1/profiles/{profile}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/profiles"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Request $request
     * @param Profile $profile
     * @return JsonResponse
     */
    public function update(Request $request, Profile $profile): JsonResponse
    {
        $profile->update($request->all());
        return $this->successResponse($profile->refresh());
    }

    /**
     *
     * @OA\Delete (
     *     path="/main/api/v1/profiles/{profile}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/profiles"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Profile $profile
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Profile $profile): JsonResponse
    {
        return $this->successResponse($profile->delete());
    }
}
