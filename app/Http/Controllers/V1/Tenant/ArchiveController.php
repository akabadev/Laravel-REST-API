<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Archivers\Archiver;
use App\Archivers\OrdersArchiver;
use App\Http\Controllers\V1\BaseController;
use App\Models\Tasks\ArchiveTask;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use ReflectionException;

class ArchiveController extends BaseController
{
    public function __construct()
    {
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/archives",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"archives"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
     * @param OrdersArchiver $archiver
     * @return JsonResponse
     */
    public function index(Archiver $archiver): JsonResponse
    {
        return $this->successResponse(DB::table($archiver->tableName())->paginate());
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/archives",
     *     summary="Archive orders table",
     *     description="Archive orders table",
     *     tags={"archives"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function store(): JsonResponse
    {
        $task = ArchiveTask::create();

        $task->queue();

        return $this->successResponse($task, "archiver task is being created");
    }
}
