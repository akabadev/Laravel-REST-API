<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\Page\CreatePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\Page;
use Exception;
use Illuminate\Http\JsonResponse;

class CentralPageController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/pages",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/pages"},
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Page")),
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
        return $this->successResponse(Page::paginate());
    }

    /**
     * @OA\Post (
     *     path="/main/api/v1/pages",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/pages"},
     *     @OA\RequestBody(ref="#/components/requestBodies/CreatePageRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreatePageRequest $request
     * @return JsonResponse
     */
    public function store(CreatePageRequest $request): JsonResponse
    {
        return $this->successResponse(Page::create($request->validated()));
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/pages/{page}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"central/pages"},
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePageRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Page $page
     * @return JsonResponse
     */
    public function show(Page $page): JsonResponse
    {
        return $this->successResponse($page);
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/pages/{page}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/pages"},
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePageRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/main/api/v1/pages/{page}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/pages"},
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePageRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdatePageRequest $request
     * @param Page $page
     * @return JsonResponse
     */
    public function update(UpdatePageRequest $request, Page $page): JsonResponse
    {
        $page->update($request->validated());
        return $this->successResponse($page->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/main/api/v1/pages/{page}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/pages"},
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Page $page
     * @return JsonResponse
     */
    public function destroy(Page $page): JsonResponse
    {
        return $this->successResponse($page->delete());
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/pages/{page}/config",
     *     summary="Display the page config file",
     *     description="Display the page config file",
     *     tags={"central/pages"},
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Page $page
     * @return JsonResponse
     * @throws Exception
     */
    public function config(Page $page): JsonResponse
    {
        return $this->successResponse($page->config());
    }
}
