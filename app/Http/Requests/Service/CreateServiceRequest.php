<?php

namespace App\Http\Requests\Service;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateServiceRequest",
 *     description="Create Service Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="92879827-UII"),
 *         @OA\Property(property="bo_reference", type="string", example="UY666666-899"),
 *         @OA\Property(property="customer_id", type="integer", example="1"),
 *         @OA\Property(property="name", type="string", example="Tim Cook"),
 *         @OA\Property(property="contact_name", type="string", example="Tim Cook"),
 *         @OA\Property(property="address_id", type="integer", example="1"),
 *         @OA\Property(property="delivery_site", type="string", example="Siège d'Apple")
 *    )
 * )
 *
 * Class CreateServiceRequest
 * @package App\Http\Requests\Service
 */
class CreateServiceRequest extends FormRequest
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
            "code" => "required|alpha_num|min:5",
            "bo_reference" => "required|alpha_num|min:5",
            "customer_id" => "required|exists:customers,id",
            "name" => "required|string|min:1",
            "contact_name" => "required|string|min:5",
            "address_id" => "required|exists:addresses,id",
            "delivery_site" => "required|string|min:5",
        ];
    }
}
