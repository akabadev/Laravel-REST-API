<?php

namespace App\Http\Requests\Beneficiary;

use App\Models\Beneficiary;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateBeneficiaryRequest",
 *     description="Update Beneficiary Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="1234567890"),
 *         @OA\Property(property="first_name", type="string", example="John"),
 *         @OA\Property(property="last_name", type="string", example="Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *         @OA\Property(property="profile", type="string", example="admin|standard|customer"),
 *         @OA\Property(property="address_id", type="integer", example="1"),
 *         @OA\Property(property="service_id", type="integer", example="2")
 *    )
 * )
 *
 * Class UpdateBeneficiaryRequest
 * @package App\Http\Requests\Beneficiary
 */
class UpdateBeneficiaryRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge(["profile" => Beneficiary::$PROFILES[0]]);
    }

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
            "code" => "string|min:1",
            "first_name" => "string|min:1",
            "last_name" => "string|min:1",
            "email" => "email",
            "profile" => "in:" . implode(",", Beneficiary::$PROFILES),
            "address_id" => "exists:addresses,id",
            "service_id" => "exists:services,id",
        ];
    }
}
