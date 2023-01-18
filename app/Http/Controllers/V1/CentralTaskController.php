<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Jobs\ValidateImportJob;
use App\Models\Contracts\CanBeValidated;
use App\Models\Contracts\Downloadable;
use App\Models\Contracts\HasDetails;
use App\Models\Process;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

class CentralTaskController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/processes/{process}/tasks",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/tasks"},
     *     @OA\Parameter(ref="#/components/parameters/process"),
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
        return $this->successResponse($process->tasks()->paginate());
    }

    /**
     * @OA\Post (
     *     path="/main/api/v1/processes/{process}/tasks",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/tasks"},
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
        return $this->successResponse($process->tasks()->create($request->validated())->concrete());
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/processes/{process}/tasks/{task}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"central/tasks"},
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
     * @param Process $process
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Process $process, Task $task): JsonResponse
    {
        $process->tasks()->findOrFail($task->id);
        return $this->successResponse($task->concrete());
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/processes/{process}/tasks/{task}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/tasks"},
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
     *     path="/main/api/v1/processes/{process}/tasks/{task}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/tasks"},
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
        $process->tasks()->findOrFail($task->id)->update($request->all());
        return $this->successResponse($task->concrete()->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/main/api/v1/processes/{process}/tasks/{task}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/tasks"},
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
        return $this->successResponse($process->tasks()->findOrFail($task->id)->delete());
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/processes/{process}/tasks/{task}/details",
     *     summary="Task Details",
     *     description="Task Details",
     *     tags={"central/tasks"},
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
        /** @var Task $task */
        $task = $process->tasks()->findOrFail($task->id)->concrete();

        return $task instanceof HasDetails ?
            $this->successResponse($task->getDetails()) :
            $this->errorResponse([], "This task doesn't have details");
    }

    /**
     * @OA\Post  (
     *     path="/main/api/v1/processes/{process}/tasks/{task}/validate",
     *     summary="Validate Task",
     *     description="Validate Task",
     *     tags={"central/tasks"},
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
        /** @var Task $task */
        $task = $process->tasks()->findOrFail($task->id)->concrete();

        if (!$task instanceof CanBeValidated) {
            return $this->errorResponse([], 'This task cannot be validated');
        }

        if ($task->isValidable()) {
            Queue::laterOn(
                'tasks',
                now()->addSecond(),
                ValidateImportJob::instance($task)
            );
        }

        return $task->isValidable() ?
            $this->successResponse(message: "Validation de l'import encours...") :
            $this->errorResponse(message: 'Please retry later', code: Response::HTTP_TOO_EARLY, status: Response::HTTP_TOO_EARLY);
    }

    /**
     * @OA\Post  (
     *     path="/main/api/v1/processes/{process}/tasks/{task}/download",
     *     summary="Download Task result",
     *     description="Download Task result",
     *     tags={"central/tasks"},
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
        /** @var Task $task */
        $task = $process->tasks()->findOrFail($task->id)->concrete();

        if (!$task instanceof Downloadable) {
            return $this->errorResponse([], 'This task cannot be downloaded');
        }

        throw_if(
            !$task->isReady() || !file_exists($task->filePath()),
            NotFoundResourceException::class,
            ['File not ready yet. Or is missing']
        );

        return response()->download($task->filePath());
    }
}
