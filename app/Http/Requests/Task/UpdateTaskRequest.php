<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateTaskRequest",
 *     description="UpdateTaskRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="comment", type="string", example="Comment here ..."),
 *         @OA\Property(property="attempts", type="integer", example="1"),
 *         @OA\Property(property="payload", type="array", example="[]", @OA\Items()),
 *         @OA\Property(property="status_id", type="integer", example="1"),
 *         @OA\Property(property="process_id", type="integer", example="1"),
 *         @OA\Property(property="limited_at", type="string", format="datetime", description="Limit timestamp", readOnly="true"),
 *         @OA\Property(property="available_at", type="string", format="datetime", description="Start timestamp", readOnly="true"),
 *     )
 * )
 *
 * Class UpdateTaskRequest
 * @package App\Http\Requests\Task
 */
class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'process_id' => 'required',
            'status_id' => 'required',
            'payload' => 'required',
            'limited_at' => 'after_or_equal:' . now()->toString(),
            'available_at' => 'after_or_equal:' . now()->toString(),
            'comment' => 'required|string'
        ];
    }
}
