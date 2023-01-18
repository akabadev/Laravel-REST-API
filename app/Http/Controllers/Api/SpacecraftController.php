<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\V1\BaseController;

use App\Http\Requests\StoreSpacecraftRequest;
use App\Http\Requests\UpdateSpacecraftRequest;
use App\Http\Resources\SpacecraftCollection;
use App\Repository\Contracts\Interfaces\SpacecraftRepositoryInterface;
use App\Http\Resources\Spacecraft as SpacecraftResource;
use App\Models\Spacecraft;
use Illuminate\Http\JsonResponse;

class SpacecraftController extends BaseController
{


    public function __construct(private SpacecraftRepositoryInterface $repository)
    {
       $this->repository = $repository;
    }


    /**
     * @OA\Get (
     *     path="/main/api/v1/spacecrafts",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"spacecrafts"},
     *     @OA\RequestBody(description="Ship side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
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
    //using '_' as default. In the restful URL, empty will lead to name//status/0
    public function index($name = '_', $class = '_', $status = 0)
    {
        $all = new SpacecraftCollection(Spacecraft::search([ 'name' => $name, 'class' => $class, 'status' => $status ]));
        return $this->successResponse($all);

    }



    /**
     * @OA\Get (
     *     path="/main/api/v1/spacecrafts/{spacecraft}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"spacecrafts"},
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Spacecraft $spacecraft
     * @return JsonResponse
     */
    public function show(Spacecraft $spacecraft): JsonResponse
    {
        $spacecraft = new SpacecraftResource($spacecraft, true);
        return $this->successResponse($spacecraft);
    }


    /**
     * @OA\Post (
     *     path="/main/api/v1/spacecrafts",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"spacecrafts"},
     *     @OA\RequestBody(ref="#/components/requestBodies/StoreSpacecraftRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param StoreSpacecraftRequest $request
     * @return JsonResponse
     */
    public function store(StoreSpacecraftRequest $request): JsonResponse
    {
        return $this->successResponse($request->persist());

 
    }



    /**
     * @OA\Put (
     *     path="/main/api/v1/spacecrafts/{spacecraft}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"spacecrafts"},
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateSpacecraftRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateSpacecraftRequest $request
     * @param Spacecraft $spacecraft
     * @return JsonResponse
     */
    public function update( UpdateSpacecraftRequest $request): JsonResponse
    {
        return $this->successResponse($request->persist());

    }


    /**
     * @OA\Delete (
     *     path="/main/api/v1/spacecrafts/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"spacecrafts"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Spacecraft id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Spacecraft $spacecraft) : JsonResponse
    {
       return $this->successResponse($spacecraft->delete());      
    }
}
