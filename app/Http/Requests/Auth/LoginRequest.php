<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\RequestBody(
 *     request="LoginRequest",
 *     description="LoginRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="email", type="string", example="akabadev@gmail.com"),
 *         @OA\Property(property="password", type="string", example="Logiweb2021*")
 *     )
 * )
 *
 * Class LoginRequest
 * @package App\Http\Requests\Auth
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $method = param("authentication.by");

        return [
            $method => "required|exists:users,$method",
            "password" => "required|string",
        ];
    }
}
