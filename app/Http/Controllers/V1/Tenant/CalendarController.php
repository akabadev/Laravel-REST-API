<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\Calendar\CreateCalendarRequest;
use App\Http\Requests\Calendar\UpdateCalendarRequest;
use App\Models\Calendar;
use Illuminate\Http\JsonResponse;

class CalendarController extends BaseController
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/calendars",
     *     summary="Display  calendar of the resource.",
     *     description="Display calendar of the resource.",
     *     tags={"calendars"},
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="array", @OA\Items(type="object", ref="#/components/schemas/Calendar")),
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
        return $this->successResponse(Calendar::paginate());
    }

    /**
     * @OA\Post (
     *     path="/{tenant}/api/v1/calendars",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\RequestBody(ref="#/components/requestBodies/CreateCalendarRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateCalendarRequest $request
     * @return JsonResponse
     */
    public function store(CreateCalendarRequest $request): JsonResponse
    {
        return $this->successResponse(Calendar::create($request->validated()));
    }

    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/calendars/{calendar}",
     *     summary="Display the specified resource.",
     *     description="Display the specified resource.",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Calendar $calendar
     * @return JsonResponse
     */
    public function show(Calendar $calendar): JsonResponse
    {
        return $this->successResponse($calendar);
    }

    /**
     * @OA\Patch (
     *     path="/{tenant}/api/v1/calendars/{calendar}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateCalendarRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/{tenant}/api/v1/calendars/{calendar}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateCalendarRequest"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateCalendarRequest $request
     * @param Calendar $calendar
     * @return JsonResponse
     */
    public function update(UpdateCalendarRequest $request, Calendar $calendar): JsonResponse
    {
        $calendar->update($request->validated());
        return $this->successResponse($calendar->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/{tenant}/api/v1/calendars/{calendar}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"calendars"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(ref="#/components/parameters/calendar"),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param Calendar $calendar
     * @return JsonResponse
     */
    public function destroy(Calendar $calendar): JsonResponse
    {
        return $this->successResponse($calendar->delete());
    }
}
