<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Format\CreateFormatRequest;
use App\Http\Requests\Format\UpdateFormatRequest;
use App\Models\Format;
use Illuminate\Http\JsonResponse;

class FormatController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/formats",
     *     summary="Display  format of the resource.",
     *     description="Display format of the resource.",
     *     tags={"formats"},
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Format")),
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
        return $this->successResponse(Format::paginate());
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/formats",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"formats"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateFormatRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateFormatRequest $request
     * @return JsonResponse
     */
    public function store(CreateFormatRequest $request): JsonResponse
    {
        return $this->successResponse(Format::create($request->validated()));
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/formats/{format}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"formats"},
     *     @OA\Parameter(ref="#/components/parameters/format"),
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Format $format
     * @return JsonResponse
     */
    public function show(Format $format): JsonResponse
    {
        return $this->successResponse($format);
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/formats/{format}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"formats"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/format"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateFormatRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/formats/{format}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"formats"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/format"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateFormatRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateFormatRequest $request
     * @param Format $format
     * @return JsonResponse
     */
    public function update(UpdateFormatRequest $request, Format $format): JsonResponse
    {
        $format->update($request->validated());
        return $this->successResponse($format->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/formats/{format}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"formats"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/format"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Format $format
     * @return JsonResponse
     */
    public function destroy(Format $format): JsonResponse
    {
        return $this->successResponse($format->delete());
    }
}
