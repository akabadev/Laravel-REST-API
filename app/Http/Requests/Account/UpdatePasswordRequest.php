<?php

namespace App\Http\Requests\Account;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdatePasswordRequest",
 *     description="Update Password Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="password", type="string", example="StrongP@$word09876543#"),
 *         @OA\Property(property="password_confirmation", type="string", example="StrongP@$word09876543#")
 *     )
 * )
 *
 * Class UpdatePasswordRequest
 * @package App\Http\Requests\Account
 */
class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->tokenCan('change-password');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string|min:8|confirmed'
        ];
    }
}
