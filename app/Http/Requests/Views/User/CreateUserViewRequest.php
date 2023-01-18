<?php

namespace App\Http\Requests\Views\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateUserViewRequest",
 *     description="Update User View Request",
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *         @OA\Property(property="profile_code", type="string", example="ADMIN")
 *    )
 * )
 *
 * Class CreateUserViewRequest
 * @package App\Http\Requests\User
 */
class CreateUserViewRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email ?? "")
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return collect(data_get(client_config("imports/users.json"), "columns"))
            ->map(fn (array $column) => $column["validation"])
            ->toArray();
    }
}
