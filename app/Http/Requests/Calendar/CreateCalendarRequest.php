<?php

namespace App\Http\Requests\Calendar;

use App\Models\Calendar;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateCalendarRequest",
 *     description="Create Calendar Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="1234567890"),
 *         @OA\Property(property="name", type="string", example="Calendar 2021"),
 *         @OA\Property(property="period_type", type="string", example="weeks"),
 *         @OA\Property(property="start_at", type="datetime"),
 *         @OA\Property(property="end_at", type="datetime")
 *    )
 * )
 *
 * Class CreateCalendarRequest
 * @package App\Http\Requests\Calendar
 */
class CreateCalendarRequest extends FormRequest
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
        return [
            "name" => "required|min:1|max:50|unique:calendars,name",
            "code" => "required|alpha_num|min:1|max:50|unique:calendars,code",
            "period_type"=>"min:1|in:" . implode(",", Calendar::PERIOD_TYPES),
            'start_at' => 'after_or_equal:' . now()->toString(),
            'end_at' => 'after_or_equal:' . now()->toString(),
        ];
    }
}
