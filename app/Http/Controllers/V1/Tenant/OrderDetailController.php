<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Order\CreateOrderDetailRequest;
use App\Http\Requests\Order\UpdateOrderDetailRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\JsonResponse;

class OrderDetailController extends BaseController
{
    public function __construct()
    {
        $this->authorizeResource(OrderDetail::class, 'detail');
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/orders/{order}/details",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/OrderDetail")),
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
     * @param Order $order
     * @return JsonResponse
     */
    public function index(Order $order): JsonResponse
    {
        return $this->successResponse($order->order_details()->paginate());
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/orders/{order}/details",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateOrderDetailRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateOrderDetailRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function store(CreateOrderDetailRequest $request, Order $order): JsonResponse
    {
        return $this->successResponse($order->order_details()->create($request->validated()));
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/orders/{order}/details/{detail}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\Parameter(ref="#/components/parameters/detail"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Order $order
     * @param OrderDetail $detail
     * @return JsonResponse
     */
    public function show(Order $order, OrderDetail $detail): JsonResponse
    {
        return $this->successResponse($order->order_details()->findOrFail($detail->id));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/orders/{order}/details/{detail}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\Parameter(ref="#/components/parameters/detail"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateOrderDetailRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/orders/{order}/details/{detail}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateOrderRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateOrderDetailRequest $request
     * @param Order $order
     * @param OrderDetail $detail
     * @return JsonResponse
     */
    public function update(UpdateOrderDetailRequest $request, Order $order, OrderDetail $detail): JsonResponse
    {
        $detail->update($request->validated());
        return $this->successResponse($detail->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/orders/{order}/details/{detail}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Order $order
     * @param OrderDetail $detail
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Order $order, OrderDetail $detail): JsonResponse
    {
        return $this->successResponse($order->order_details()->findOrFail($detail->id)->delete());
    }
}
