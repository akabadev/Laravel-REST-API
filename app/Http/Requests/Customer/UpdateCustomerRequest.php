<?php

namespace App\Http\Requests\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateCustomerRequest",
 *     description="Update Customer Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="2628772687"),
 *         @OA\Property(property="bo_reference", type="string", example="92879827-UII"),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="contact_name", type="string", example="John Doe"),
 *         @OA\Property(property="active", type="boolean", example="true"),
 *         @OA\Property(property="address_id", type="integer", example="1")
 *    )
 * )
 *
 * Class UpdateCustomerRequest
 * @package App\Http\Requests\Customer
 */
class UpdateCustomerRequest extends FormRequest
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
            "code" => "alpha_num|min:1",
            "bo_reference" => "alpha_num|min:5",
            "name" => "string",
            "is_active" => "boolean",
            "contact_name" => "string|min:5",
            "address_id" => "exists:addresses,id",
        ];
    }
}
