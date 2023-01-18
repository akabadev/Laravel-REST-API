<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateAddressRequest",
 *     description="UpdateAddressRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="address_1", type="string", example="1 Route de Mars"),
 *         @OA\Property(property="address_2", type="string", example="Etage 1"),
 *         @OA\Property(property="postal_code", type="string", example="75000"),
 *         @OA\Property(property="town", type="string", example="Paris"),
 *         @OA\Property(property="country", type="string", example="Frnace"),
 *     )
 * )
 *
 * Class UpdateAddressRequest
 * @package App\Http\Requests\Address
 */
class UpdateAddressRequest extends FormRequest
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
            "address_1" => "string|min:5",
            "address_2" => "string",
            "postal_code" => "integer|min:1",
            "town" => "string|min:1",
            "country" => "string|min:1",
        ];
    }
}
