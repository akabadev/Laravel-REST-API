<?php

namespace App\Http\Requests\Views\Service;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateServiceViewRequest",
 *     description="Update Service View Request",
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="XTGEBEBE-00000"),
 *         @OA\Property(property="bo_reference", type="string", example="B09999999"),
 *         @OA\Property(property="customer_id", type="string", example="1"),
 *         @OA\Property(property="name", type="integer", example="Name"),
 *         @OA\Property(property="contact_name", type="integer", example="Contact 2"),
 *         @OA\Property(property="address_id", type="string", example="1"),
 *         @OA\Property(
 *              property="address",
 *              type="array",
 *              @OA\Items(
 *                  @OA\Property(property="address_1", type="string", example="Etage 1"),
 *                  @OA\Property(property="address_2", type="string", example="Etage 1"),
 *                  @OA\Property(property="postal_code", type="string", example="75000"),
 *                  @OA\Property(property="city", type="string", example="Paris"),
 *                  @OA\Property(property="country", type="string", example="Frnace"),
 *              )
 *         ),
 *    )
 * )
 *
 * Class CreateServiceRequest
 * @package App\Http\Requests\Service
 */
class UpdateServiceViewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $service = $this->route("service");

        return [
            "code" => "string|unique:services,code,$service->id",
            "bo_reference" => "string",
            "customer_id" => "exists:customers,id",
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
