<?php

namespace App\Http\Requests\Calendar;

use App\Models\Calendar;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateCalendarRequest",
 *     description="Update Calendar Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="1234567890"),
 *         @OA\Property(property="name", type="string", example="Calendar 2021"),
 *         @OA\Property(property="period_type", type="string", example="week"),
 *         @OA\Property(property="start_at", type="datetime"),
 *         @OA\Property(property="end_at", type="datetime")
 *    )
 * )
 *
 * Class UpdateCalendarRequest
 * @package App\Http\Requests\Calendar
 */
class UpdateCalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $calendar = $this->route("calendar");
        return [
            "name" => "min:1|max:50|unique:calendars,name",
            "code" => "alpha_num|min:1|max:50|unique:calendars,code,$calendar->id",
            "period_type" => "min:1|in:" . implode("", Calendar::PERIOD_TYPES),
            "start_at" => "after_or_equal:" . now()->toString(),
            "end_at" => "after_or_equal:" . now()->toString(),
        ];
    }
}
