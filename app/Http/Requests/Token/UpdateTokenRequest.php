<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateTokenRequest",
 *     description="UpdateTokenRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="abilities", type="array", example="['*']", @OA\Items())
 *     )
 * )
 *
 * Class UpdateTokenRequest
 * @package App\Http\Requests\Token
 */
class UpdateTokenRequest extends FormRequest
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
            "abilities" => "required|array",
            "abilities.*" => "required|string",
        ];
    }
}
