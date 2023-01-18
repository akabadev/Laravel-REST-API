<?php

namespace App\Http\Requests\Token;

use App\Models\PersonalAccessToken;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateTokenRequest",
 *     description="CreateTokenRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="Token Name"),
 *         @OA\Property(property="user_id", type="integer", example="1"),
 *         @OA\Property(property="abilities", type="array", example="['*']", @OA\Items())
 *     )
 * )
 *
 * Class CreateTokenRequest
 * @package App\Http\Requests\Token
 */
class CreateTokenRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge(["name" => PersonalAccessToken::GENERATED_TOKEN_NAME]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "user_id" => "required|exists:users,id",
            "name" => "required|string",
            "abilities" => "required|array",
            "abilities.*" => "required|string",
        ];
    }
}
