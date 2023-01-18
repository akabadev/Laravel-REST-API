<?php

namespace App\Http\Controllers\V1\Tenant\Views;

use App\Contracts\IO\Export\ExportationServiceFactory;
use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Views\Beneficiary\CreateBeneficiaryViewRequest;
use App\Http\Requests\Views\Beneficiary\ImportBeneficiariesRequest;
use App\Http\Requests\Views\Beneficiary\UpdateBeneficiaryViewRequest;
use App\Jobs\ExportViewableJob;
use App\Jobs\ImportJob;
use App\Models\Beneficiary;
use App\Models\Process;
use App\Models\Tasks\ExportTask;
use App\Models\Tasks\ImportTask;
use App\Repository\Contracts\Interfaces\BeneficiaryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Throwable;

class BeneficiaryViewController extends BaseController
{
    public function __construct(private BeneficiaryRepositoryInterface $repository)
    {
    }

    /**
     * @OA\Get(
     *     path="/{tenant}/api/v1/views/beneficiaries",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"views/beneficiaries"},
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
     *                      ref="#/components/schemas/Beneficiary"
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
     *     path="/{tenant}/api/v1/views/beneficiaries",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"views/beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateBeneficiaryViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateBeneficiaryViewRequest $request
     * @return JsonResponse
     */
    public function store(CreateBeneficiaryViewRequest $request): JsonResponse
    {
        return $this->successResponse($this->repository->create($request->validated()));
    }

    /**
     * @OA\Get  (
     *     path="/{tenant}/api/v1/views/beneficiaries/{beneficiary}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"views/beneficiaries"},
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
        return $this->successResponse($this->repository->formater()($beneficiary));
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/views/beneficiaries/{beneficiary}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/beneficiary"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateBeneficiaryViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/views/beneficiaries/{beneficiary}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"views/beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/beneficiary"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateBeneficiaryViewRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateBeneficiaryViewRequest $request
     * @param Beneficiary $beneficiary
     * @return JsonResponse
     */
    public function update(UpdateBeneficiaryViewRequest $request, Beneficiary $beneficiary): JsonResponse
    {
        $this->repository->update($beneficiary, $request->validated());
        return $this->successResponse($this->repository->formater()($beneficiary));
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/views/beneficiaries/{beneficiary}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"views/beneficiaries"},
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
    public function destroy(Beneficiary $beneficiary): JsonResponse
    {
        return $this->successResponse($this->repository->delete($beneficiary));
    }

    /**
     * @OA\Post(
     *     path="/{tenant}/api/v1/views/beneficiaries/export/{type}",
     *     summary="Export the specified resource from storage",
     *     description="Export the specified resource from storage",
     *     tags={"views/beneficiaries"},
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
            'process_id' => $process->id,
            'status_id' => ExportTask::EXPORT_PENDING_ID(),
            'payload' => [
                'filters' => $request->all(),
                'repository' => BeneficiaryRepositoryInterface::class,
                'service' => $type,
                'config' => 'exports/beneficiaries.json'
            ],
            'available_at' => now(),
            'comment' => 'Exportation des bénéficiaires',
        ]);

        $task->queue();

        return $this->successResponse($task);
    }

    /**
     * @OA\Post(
     *     path="/{tenant}/api/v1/views/beneficiaries/import",
     *     summary="ImportTask a collection of beneficiaries to the storage",
     *     description="ImportTask a collection of beneficiaries to the storage in `csv` format",
     *     tags={"views/beneficiaries"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/ImportBeneficiariesRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param ImportBeneficiariesRequest $request
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function import(ImportBeneficiariesRequest $request): JsonResponse
    {
        $file = $request->file("file");
        $filename = strtoupper(md5(time())) . "." . $file->clientExtension();
        $directory = client_storage("imports");
        $file->move($directory, $filename);

        $task = ImportTask::create([
            "process_id" => Process::findOrCreateWithInvokable(ImportJob::class, [])->id,
            "status_id" => ImportTask::getListingByCode(ImportTask::IMPORT_PENDING)->id,
            "payload" => [
                "file" => Str::finish($directory, DIRECTORY_SEPARATOR) . $filename,
                "service" => $file->clientExtension(),
                "repository" => BeneficiaryRepositoryInterface::class,
                "config" => "imports/beneficiaries.json"
            ],
            "available_at" => now(),
            "comment" => "Importation des bénéficiaires",
        ]);

        $task->queue();

        return $this->successResponse($task);
    }
}
