<?php

namespace App\Http\Requests\Process;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateProcessRequest",
 *     description="UpdateProcessRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="92879827-UII"),
 *         @OA\Property(property="description", type="string", example="Description..."),
 *         @OA\Property(property="invokable", type="string", example="MorphToClass")
 *     )
 * )
 *
 * Class UpdateProcessRequest
 * @package App\Http\Requests\Process
 */
class UpdateProcessRequest extends FormRequest
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
            "code" => "alpha_num",
            "description" => "string",
            "invokable" => "string"
        ];
    }
}
