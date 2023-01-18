<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Beneficiary\CreateBeneficiaryRequest;
use App\Http\Requests\Beneficiary\UpdateBeneficiaryRequest;
use App\Models\Beneficiary;
use App\Repository\Contracts\Interfaces\BeneficiaryRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class BeneficiaryController extends BaseController
{
    public function __construct(private BeneficiaryRepositoryInterface $repository)
    {
        $this->authorizeResource(Beneficiary::class);
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/beneficiaries",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Beneficiary")),
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
        return $this->successResponse($this->repository->index());
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/beneficiaries",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateBeneficiaryRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateBeneficiaryRequest $request
     * @return JsonResponse
     */
    public function store(CreateBeneficiaryRequest $request): JsonResponse
    {
        return $this->successResponse(Beneficiary::create($request->validated()));
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/beneficiaries/{beneficiary}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/beneficiary"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Beneficiary $beneficiary
     * @return JsonResponse
     */
    public function show(Beneficiary $beneficiary): JsonResponse
    {
        return $this->successResponse($this->repository->format($beneficiary));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/beneficiaries/{beneficiary}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/beneficiary"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateBeneficiaryRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/beneficiaries/{beneficiary}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/beneficiary"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateBeneficiaryRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateBeneficiaryRequest $request
     * @param Beneficiary $beneficiary
     * @return JsonResponse
     */
    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary): JsonResponse
    {
        $beneficiary->update($request->validated());
        return $this->successResponse($this->repository->format($beneficiary->refresh()));
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/beneficiaries/{beneficiary}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/beneficiary"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Beneficiary $beneficiary
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Beneficiary $beneficiary): JsonResponse
    {
        return $this->successResponse($beneficiary->delete());
    }
}
