<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\CentralTaskController;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Process;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class TaskController extends CentralTaskController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/processes/{process}/tasks",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Task")),
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
     * @param Process $process
     * @return JsonResponse
     */
    public function index(Process $process): JsonResponse
    {
        return parent::index($process);
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/processes/{process}/tasks",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateTaskRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateTaskRequest $request
     * @param Process $process
     * @return JsonResponse
     */
    public function store(CreateTaskRequest $request, Process $process): JsonResponse
    {
        return parent::store($request, $process);
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Process $process, Task $task): JsonResponse
    {
        return parent::show($process, $task);
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTaskRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTaskRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateTaskRequest $request
     * @param Process $process
     * @param Task $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Process $process, Task $task): JsonResponse
    {
        return parent::update($request, $process, $task);
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy(Process $process, Task $task): JsonResponse
    {
        return parent::destroy($process, $task);
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}/details",
     *     summary="Task Details",
     *     description="Task Details",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @param Task $task
     * @return JsonResponse
     */
    public function details(Process $process, Task $task): JsonResponse
    {
        return parent::details($process, $task);
    }

    /**
     * @OA\Post  (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}/validate",
     *     summary="Validate Task",
     *     description="Validate Task",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @param Task $task
     * @return JsonResponse
     */
    public function validateTask(Process $process, Task $task): JsonResponse
    {
        return parent::validateTask($process, $task);
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/processes/{process}/tasks/{task}/download",
     *     summary="Download Task result",
     *     description="Download Task result",
     *     tags={"tasks"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
     *     @OA\Parameter(ref="#/components/parameters/task"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Process $process
     * @param Task $task
     * @return JsonResponse|BinaryFileResponse
     * @throws Throwable
     */
    public function download(Process $process, Task $task): BinaryFileResponse|JsonResponse
    {
        return parent::download($process, $task);
    }
}
