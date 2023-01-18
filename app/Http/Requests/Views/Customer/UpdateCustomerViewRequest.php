<?php

namespace App\Http\Requests\Views\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateCustomerViewRequest",
 *     description="Update Customer Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="2628772687"),
 *         @OA\Property(property="bo_reference", type="string", example="92879827-UII"),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="contact_name", type="string", example="John Doe"),
 *         @OA\Property(property="active", type="boolean", example="true"),
 *         @OA\Property(property="address_id", type="string", example="1"),
 *         @OA\Property(
 *              property="address",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="address_1", type="string", example="Etage 1"),
 *                  @OA\Property(property="address_2", type="string", example="Etage 1"),
 *                  @OA\Property(property="postal_code", type="string", example="75000"),
 *                  @OA\Property(property="city", type="string", example="Paris"),
 *                  @OA\Property(property="country", type="string", example="France")
 *              )
 *         ),
 *    )
 * )
 *
 * Class UpdateCustomerRequest
 * @package App\Http\Requests\Customer
 */
class UpdateCustomerViewRequest extends FormRequest
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
        $customer = $this->route("customer");

        return [
            "code" => "alpha_num|min:1|string|unique:services,code,$customer->id",
            "bo_reference" => "string",
            "name" => "string|min:5|max:255",
            "contact_name" => "string|min:5|max:255",
            "address_id" => "exists:addresses,id",
            "address" => "array",
            "address.address_1" => "string",
            "address.address_2" => "string",
            "address.postal_code" => "string",
            "address.town" => "string",
            "address.country" => "string",
            "delivery_site" => "string",
            "active" => "boolean",
        ];
    }
}
