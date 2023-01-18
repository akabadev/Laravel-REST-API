<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="ChangePasswordRequest",
 *     description="Change Password Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop")
 *     )
 * )
 *
 * Class ChangePasswordRequest
 * @package App\Http\Requests\Account
 */
class ChangePasswordRequest extends FormRequest
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
        $this->merge(['email' => Str::lower($this->email ?: '')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email'
        ];
    }
}
