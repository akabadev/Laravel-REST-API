<?php

namespace App\Http\Controllers\V1\Tenant\Views;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Views\Page\CreatePageViewRequest;
use App\Http\Requests\Views\Page\UpdatePageViewRequest;
use App\Models\Page;
use App\Repository\Contracts\Interfaces\PageRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PageViewController extends BaseController
{
    public function __construct(private PageRepositoryInterface $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/{tenant}/api/v1/views/pages",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"views/pages"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/Page"
     *                  )
     *              ),
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
        return $this->successResponse($this->repository->toView(request()->all()));
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/views/pages",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"views/pages"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreatePageViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreatePageViewRequest $request
     * @return JsonResponse
     */
    public function store(CreatePageViewRequest $request): JsonResponse
    {
        return $this->successResponse($this->repository->create($request->validated()));
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/views/pages/{page}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"views/pages"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
    public function show(Page $page): JsonResponse
    {
        return $this->successResponse($this->repository->formater()($page));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/views/pages/{page}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/pages"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePageViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/views/pages/{page}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/pages"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePageViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdatePageViewRequest $request
     * @param Page $page
     * @return JsonResponse
     */
    public function update(UpdatePageViewRequest $request, Page $page): JsonResponse
    {
        $this->repository->update($page, $request->validated());
        return $this->successResponse($this->repository->formater()($page->refresh()));
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/views/pages/{page}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"views/pages"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
        return $this->successResponse($this->repository->delete($page));
    }
}
