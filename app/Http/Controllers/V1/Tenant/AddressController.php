<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Address\CreateAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Models\Address;
use App\Repository\Contracts\Interfaces\AddressRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class AddressController extends BaseController
{
    public function __construct(private AddressRepositoryInterface $repository)
    {
        $this->authorizeResource(Address::class);
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/addresses",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"addresses"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Address")),
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
     * @OA\Post  (
     *     path="/{tenant}/api/v1/addresses",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"addresses"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateAddressRequest"),
     *     @OA\RequestBody(
     *         description="New Address Data",
     *         required=false,
     *         @OA\MediaType(mediaType="application/json"),
     *         required=true
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateAddressRequest $request
     * @return JsonResponse
     */
    public function store(CreateAddressRequest $request): JsonResponse
    {
        return $this->successResponse($this->repository->create($request->validated()));
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/addresses/{address}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"addresses"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Address $address
     * @return JsonResponse
     */
    public function show(Address $address): JsonResponse
    {
        return $this->successResponse($this->repository->format($address));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/addresses/{address}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"addresses"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateAddressRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/addresses/{address}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"addresses"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateAddressRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateAddressRequest $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(UpdateAddressRequest $request, Address $address): JsonResponse
    {
        $this->repository->update($address, $request->validated());
        return $this->successResponse($this->repository->format($address->refresh()));
    }

    /**
     *
     * @OA\Delete (
     *     path="/{tenant}/api/v1/addresses/{address}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"addresses"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Address $address
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Address $address): JsonResponse
    {
        return $this->successResponse($this->repository->delete($address));
    }
}
