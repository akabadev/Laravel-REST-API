<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\RequestBody(
 *     request="CreateUserRequest",
 *     description="Create User Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="email", type="string", format="email", description="User unique email address", example="user@gmail.com"),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="password", type="string", example="#StrongPassword-9@8@7$"),
 *         @OA\Property(property="password_confirmation", type="string", example="#StrongPassword-9@8@7$"),
 *    )
 * )
 *
 * Class CreateUserRequest
 * @package App\Http\Requests\User
 */
class CreateUserRequest extends FormRequest
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
            "name" => "required|min:5",
            "email" => "required|unique:users,email",
            "profile_id" => "required|exists:profiles,id",
            "password" => "required|string|min:8|confirmed"
        ];
    }

    /**
     * @return array
     */
    public function validated(): array
    {
        $data = parent::validated();

        $data["password"] = Hash::make($data["password"]);

        return $data;
    }
}
