<?php

namespace App\Http\Controllers\V1\Tenant\Views;

use App\Contracts\IO\Export\ExportationServiceFactory;
use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Views\Order\CreateOrderDetailViewRequest;
use App\Http\Requests\Views\Order\CreateOrderViewRequest;
use App\Http\Requests\Views\Order\ImportOrdersRequest;
use App\Http\Requests\Views\Order\UpdateOrderDetailViewRequest;
use App\Http\Requests\Views\Order\UpdateOrderViewRequest;
use App\Jobs\ExportViewableJob;
use App\Jobs\GenerateOrder;
use App\Jobs\ImportJob;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Process;
use App\Models\Task;
use App\Models\Tasks\ExportTask;
use App\Models\Tasks\GenerateOrderTask;
use App\Models\Tasks\ImportTask;
use App\Repository\Contracts\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Throwable;

class OrderViewController extends BaseController
{
    public function __construct(private OrderRepositoryInterface $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/{tenant}/api/v1/views/orders",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
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
     *                      ref="#/components/schemas/Order"
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
     *     path="/{tenant}/api/v1/views/orders",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateOrderViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateOrderViewRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderViewRequest $request): JsonResponse
    {
        return $this->successResponse($this->repository->create($request->validated()));
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/views/orders/{order}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"views/orders"},
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
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return $this->successResponse($this->repository->formater()($order));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/views/orders/{order}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateOrderViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/views/orders/{order}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateOrderViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateOrderViewRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderViewRequest $request, Order $order): JsonResponse
    {
        $this->repository->update($order, $request->validated());
        return $this->successResponse($this->repository->formater()($order));
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/views/orders/{order}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"views/orders"},
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
     * @return JsonResponse
     */
    public function destroy(Order $order): JsonResponse
    {
        return $this->successResponse($this->repository->delete($order));
    }

    /**
     * @OA\Post(
     *     path="/{tenant}/api/v1/views/orders/export/{type}",
     *     summary="Export the specified resource from storage",
     *     description="Export the specified resource from storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="type", parameter="type"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Request $request
     * @param string $type
     * @return JsonResponse
     * @throws Throwable
     */
    public function export(Request $request, string $type): JsonResponse
    {
        throw_unless(
            ExportationServiceFactory::isSupported($type),
            ValidationException::withMessages(["Export type `$type` is not supported"])
        );

        $process = Process::findOrCreateWithInvokable(ExportViewableJob::class);

        $task = ExportTask::create([
            "process_id" => $process->id,
            "status_id" => ExportTask::EXPORT_PENDING_ID(),
            "payload" => [
                "filters" => $request->all(),
                "repository" => OrderRepositoryInterface::class,
                "service" => $type,
                "config" => "exports/orders.json"
            ],
            "available_at" => now(),
            "comment" => "Exportation des commandes",
        ]);

        $task->queue();

        return $this->successResponse($task);
    }


    /**
     * @OA\Post(
     *     path="/{tenant}/api/v1/views/orders/import",
     *     summary="ImportTask a collection of orders to the storage",
     *     description="ImportTask a collection of orders to the storage in `csv` format",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/ImportOrdersRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param ImportOrdersRequest $request
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function import(ImportOrdersRequest $request): JsonResponse
    {
        $file = $request->file("file");
        $filename = strtoupper(md5(time())) . "." . $file->clientExtension();
        $directory = client_storage("imports");
        $file->move($directory, $filename);

        $task = ImportTask::create([
            "process_id" => Process::findOrCreateWithInvokable(ImportJob::class)->id,
            "status_id" => ImportTask::getListingByCode(ImportTask::IMPORT_PENDING)->id,
            "payload" => [
                "file" => Str::finish($directory, DIRECTORY_SEPARATOR) . $filename,
                "service" => $file->clientExtension(),
                "repository" => $this->repository::class,
                "config" => "imports/orders.json"
            ],
            "available_at" => now(),
            "comment" => "Importation des commandes",
        ]);

        $task->queue();

        return $this->successResponse($task);
    }

    /**
     * @OA\Get(
     *     path="/{tenant}/api/v1/views/orders/{order}/details",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
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
     *                      ref="#/components/schemas/OrderDetail"
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
     * @param Order $order
     * @return JsonResponse
     */
    public function details(Order $order): JsonResponse
    {
        return $this->successResponse($this->repository->details($order));
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/views/orders/{order}/details",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateOrderViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateOrderDetailViewRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function storeDetail(CreateOrderDetailViewRequest $request, Order $order): JsonResponse
    {
        return $this->successResponse($this->repository->formater()($this->repository->createDetail($order, $request->validated())));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/views/orders/{order}/details/{detail}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\Parameter(ref="#/components/parameters/detail"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateOrderViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/views/orders/{order}/details/{detail}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\Parameter(ref="#/components/parameters/detail"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateOrderViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateOrderDetailViewRequest $request
     * @param Order|null $order
     * @param OrderDetail $detail
     * @return JsonResponse
     */
    public function updateDetail(UpdateOrderDetailViewRequest $request, ?Order $order, OrderDetail $detail): JsonResponse
    {
        $this->repository->updateDetail($order, $detail, $request->validated());
        return $this->successResponse($this->repository->formater()($detail));
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/views/orders/{order}/details/{detail}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"views/orders"},
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
    public function destroyDetail(Order $order, OrderDetail $detail): JsonResponse
    {
        return $this->successResponse($this->repository->deleteDetail($order, $detail));
    }

    /**
     * @OA\Post  (
     *     path="/{tenant}/api/v1/views/orders/{order}/validate",
     *     summary="Validate the current order",
     *     description="Validate the current order",
     *     tags={"views/orders"},
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
     * @return JsonResponse
     * @throws Throwable
     */
    public function validateOrder(Order $order): JsonResponse
    {
        throw_if(
            $order->validated(),
            ValidationException::withMessages(["order" => "This order is already validated"])
        );

        throw_if(
            $order->details()->doesntExist(),
            ValidationException::withMessages(["details" => "The order must have a least one detail"])
        );

        $task = GenerateOrderTask::softCreate(
            Process::findOrCreateWithInvokable(GenerateOrder::class),
            Task::getListingByCode(GenerateOrderTask::GENERATION_PENDING),
            ["order" => $order->id]
        );

        $task->tapDateTime("validated_at");
        $task->queue();

        return $this->successResponse($task, "Order validated successfully");
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/views/orders/{order}/summary",
     *     summary="Validate the current order",
     *     description="Validate the current order",
     *     tags={"views/orders"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/order"),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="quantities", type="integer"),
     *              @OA\Property(property="totalAmount", type="integer"),
     *              @OA\Property(property="anonymousChecks", type="integer"),
     *              @OA\Property(property="beneficiaries", type="integer"),
     *              @OA\Property(property="totalChecks", type="integer"),
     *              @OA\Property(property="beneficiariesParts", type="integer"),
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
    public function summary(Order $order): JsonResponse
    {
        return $this->successResponse($this->repository->summary($order));
    }
}
