<?php

namespace App\Http\Requests\Views\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateUserViewRequest",
 *     description="Update User View Request",
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *         @OA\Property(property="profile_code", type="string", example="ADMIN")
 *    )
 * )
 *
 * Class UpdateUserViewRequest
 * @package App\Http\Requests\User
 */
class UpdateUserViewRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            "email" => strtolower($this->email ?? $this->route('user')->email)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $user = $this->route("user");

        return [
            "email" => "string|unique:users,email,$user->id",
            "name" => "string|min:5|max:255",
            "profile_code" => "exists:profiles,code",
            "active" => "boolean",
        ];
    }
}
