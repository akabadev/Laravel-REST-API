<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\Process\CreateProcessRequest;
use App\Http\Requests\Process\UpdateProcessRequest;
use App\Models\Process;
use Illuminate\Http\JsonResponse;

class CentralProcessController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/processes",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/processes"},
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Listing")),
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
        return $this->successResponse(Process::paginate());
    }

    /**
     * @OA\Post (
     *     path="/main/api/v1/processes",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/processes"},
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateListingRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateProcessRequest $request
     * @return JsonResponse
     */
    public function store(CreateProcessRequest $request): JsonResponse
    {
        return $this->successResponse(Process::create($request->validated()));
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/processes/{process}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"central/processes"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateListingRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @return JsonResponse
     */
    public function show(Process $process): JsonResponse
    {
        return $this->successResponse($process);
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/processes/{process}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/processes"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateListingRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/main/api/v1/processes/{process}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/processes"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateListingRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateProcessRequest $request
     * @param Process $process
     * @return JsonResponse
     */
    public function update(UpdateProcessRequest $request, Process $process): JsonResponse
    {
        $process->update($request->validated());
        return $this->successResponse($process->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/main/api/v1/processes/{process}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/processes"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @return JsonResponse
     */
    public function destroy(Process $process): JsonResponse
    {
        return $this->successResponse($process->delete());
    }
}
