<?php

namespace App\Http\Requests\Period;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreatePeriodRequest",
 *     description="Create Period Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="1234567890"),
 *         @OA\Property(property="name", type="string", example="Period 2021"),
 *         @OA\Property(property="calendar_id", type="integer", example="2"),
 *         @OA\Property(property="start_at", type="datetime"),
 *         @OA\Property(property="end_at", type="datetime")
 *    )
 * )
 *
 * Class CreatePeriodRequest
 * @package App\Http\Requests\Period
 */
class CreatePeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => "required|min:1|max:50|unique:calendars,name",
            "code" => "required|alpha_num|min:1|max:50|unique:calendars,code",
            'start_at' => 'after_or_equal:' . now()->toString(),
            'end_at' => 'after_or_equal:' . now()->toString(),
        ];
    }
}
