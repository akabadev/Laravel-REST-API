<?php

namespace App\Http\Requests\Views\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateCustomerViewRequest",
 *     description="Create Customer Request",
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
 * Class CreateCustomerRequest
 * @package App\Http\Requests\Customer
 */
class CreateCustomerViewRequest extends FormRequest
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
        $this->merge(["active" => true]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $commonRules = collect(data_get(client_config("imports/customers.json"), "columns"))
            ->map(fn (array $column) => $column["validation"])
            ->toArray();

        return array_merge(
            $commonRules,
            ["address_id" => "exists:addresses,id"]
        );
    }
}
