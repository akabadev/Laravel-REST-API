<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\CreateTemplateRequest;
use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Models\Template;
use Illuminate\Http\JsonResponse;

class CentralTemplateController extends Controller
{
    /**
     * @OA\Get (
     *     path="/main/api/v1/templates",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/templates"},
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Template")),
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
        return $this->successResponse(Template::with("tenants")->paginate());
    }

    /**
     * @OA\Post (
     *     path="/main/api/v1/templates",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/templates"},
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateTemplateRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateTemplateRequest $request
     * @return JsonResponse
     */
    public function store(CreateTemplateRequest $request): JsonResponse
    {
        return $this->successResponse(Template::create($request->validated()));
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/templates/{template}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"central/templates"},
     *     @OA\Parameter(ref="#/components/parameters/template"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTemplateRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Template $template
     * @return JsonResponse
     */
    public function show(Template $template): JsonResponse
    {
        return $this->successResponse($template);
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/templates/{template}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/templates"},
     *     @OA\Parameter(ref="#/components/parameters/template"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTemplateRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/main/api/v1/templates/{template}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/templates"},
     *     @OA\Parameter(ref="#/components/parameters/template"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTemplateRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateTemplateRequest $request
     * @param Template $template
     * @return JsonResponse
     */
    public function update(UpdateTemplateRequest $request, Template $template): JsonResponse
    {
        $template->update($request->validated());
        return $this->successResponse($template->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/main/api/v1/templates/{template}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/templates"},
     *     @OA\Parameter(ref="#/components/parameters/template"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Template $template
     * @return JsonResponse
     */
    public function destroy(Template $template): JsonResponse
    {
        return $this->successResponse($template->delete());
    }
}
