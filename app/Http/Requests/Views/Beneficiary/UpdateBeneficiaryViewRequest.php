<?php

namespace App\Http\Requests\Views\Beneficiary;

use App\Models\Beneficiary;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateBeneficiaryViewRequest",
 *     description="Update Beneficiary View Request",
 *     @OA\JsonContent(
 *         @OA\Property(property="first_name", type="string", example="John"),
 *         @OA\Property(property="last_name", type="string", example="Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *         @OA\Property(property="address_id", type="integer", example="1"),
 *         @OA\Property(property="address_1", type="string", example="1 Route de Mars"),
 *         @OA\Property(property="address_2", type="string", example="Etage 1"),
 *         @OA\Property(property="postal_code", type="string", example="75000"),
 *         @OA\Property(property="city", type="string", example="Paris"),
 *         @OA\Property(property="country", type="string", example="Frnace"),
 *    )
 * )
 *
 * Class CreateBeneficiaryRequest
 * @package App\Http\Requests\Beneficiary
 */
class UpdateBeneficiaryViewRequest extends FormRequest
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
        $this->merge(["profile" => Beneficiary::$PROFILES[0]]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return array_merge(
            [
                "first_name" => "string|min:1",
                "last_name" => "string|min:1",
                "email" => "email",
                "active" => "boolean",
                "profile" => "in:" . implode(",", Beneficiary::$PROFILES),
                "service_code" => "exists:services,code",
                "address" => "array"
            ],
            on_param(
                "beneficiary.address",
                [
                    'address.address_1' => 'string',
                    'address.address_2' => 'string',
                    'address.postal_code' => 'string',
                    'address.town' => 'string',
                    'address.country' => 'string'
                ],
                []
            )
        );
    }
}
