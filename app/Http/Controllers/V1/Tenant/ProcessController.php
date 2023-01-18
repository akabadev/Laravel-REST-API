<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\CentralProcessController;
use App\Http\Requests\Process\CreateProcessRequest;
use App\Http\Requests\Process\UpdateProcessRequest;
use App\Models\Process;
use Illuminate\Http\JsonResponse;

class ProcessController extends CentralProcessController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/processes",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"processes"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Process")),
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
        return parent::index();
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/processes",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"processes"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateProcessRequest"),
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
        return parent::store($request);
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/processes/{process}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"processes"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
    public function show(Process $process): JsonResponse
    {
        return parent::show($process);
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/processes/{process}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"processes"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateProcessRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/processes/{process}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"processes"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateProcessRequest"),
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
        return parent::update($request, $process);
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/processes/{process}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"processes"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
        return parent::destroy($process);
    }
}
