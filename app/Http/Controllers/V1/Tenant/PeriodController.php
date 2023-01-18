<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Period\CreatePeriodRequest;
use App\Http\Requests\Period\UpdatePeriodRequest;
use App\Models\Calendar;
use App\Models\Period;
use Illuminate\Http\JsonResponse;

class PeriodController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/calendars/{calendar}/periods",
     *     summary="Display  period of the resource.",
     *     description="Display period of the resource.",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Period")),
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
     * @param Calendar $calendar
     * @return JsonResponse
     */
    public function index(Calendar $calendar): JsonResponse
    {
        return $this->successResponse($calendar->periods()->paginate());
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/calendars/{calendar}/periods",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreatePeriodRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreatePeriodRequest $request
     * @param Calendar $calendar
     * @return JsonResponse
     */
    public function store(CreatePeriodRequest $request, Calendar $calendar): JsonResponse
    {
        return $this->successResponse($calendar->periods()->create($request->validated()));
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/calendars/{calendar}/periods/{period}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\Parameter(ref="#/components/parameters/period"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Calendar $calendar
     * @param Period $period
     * @return JsonResponse
     */
    public function show(Calendar $calendar, Period $period): JsonResponse
    {
        $calendar->periods()->findOrFail($period->id);
        return $this->successResponse($period);
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/calendars/{calendar}/periods/{period}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\Parameter(ref="#/components/parameters/period"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePeriodRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/calendars/{calendar}/periods/{period}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\Parameter(ref="#/components/parameters/period"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdatePeriodRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdatePeriodRequest $request
     * @param Calendar $calendar
     * @param Period $period
     * @return JsonResponse
     */
    public function update(UpdatePeriodRequest $request, Calendar $calendar, Period $period): JsonResponse
    {
        $calendar->periods()->findOrFail($period->id);
        $period->update($request->validated());
        return $this->successResponse($period->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/calendars/{calendar}/periods/{period}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\Parameter(ref="#/components/parameters/period"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Calendar $calendar
     * @param Period $period
     * @return JsonResponse
     */
    public function destroy(Calendar $calendar, Period $period): JsonResponse
    {
        $calendar->periods()->findOrFail($period->id);
        return $this->successResponse($period->delete());
    }
}
