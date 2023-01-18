<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="UpdateUserRequest",
 *     description="Update User Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="email", type="string", format="email", description="User unique email address", example="user@gmail.com"),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="new_password", type="string", example="#StrongPassword-9@8@7$"),
 *         @OA\Property(property="new_password_confirmation", type="string", example="#StrongPassword-9@8@7$"),
 *    )
 * )
 *
 * Class UpdateUserRequest
 * @package App\Http\Requests\User
 */
class UpdateUserRequest extends FormRequest
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
        if (strlen($this->email)) {
            $this->merge(["email" => Str::lower($this->email)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => "string|min:5",
            "email" => "string|email|unique:users,email,{$this->user()->id}",
            "profile_id" => "exists:profiles,id",
            "new_password" => "string|min:8|confirmed",
        ];
    }

    public function validated(): array
    {
        $data = parent::validated();

        if ($data["new_password"] ?? false) {
            $data["password"] = Hash::make($data["new_password"]);
            unset($data["new_password"]);
        }

        return $data;
    }
}
