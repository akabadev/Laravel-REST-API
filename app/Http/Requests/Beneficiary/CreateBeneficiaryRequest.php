<?php

namespace App\Http\Requests\Beneficiary;

use App\Models\Beneficiary;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateBeneficiaryRequest",
 *     description="Create Beneficiary Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="1234567890"),
 *         @OA\Property(property="first_name", type="string", example="John"),
 *         @OA\Property(property="last_name", type="string", example="Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *         @OA\Property(property="address_id", type="integer", example="1"),
 *         @OA\Property(property="service_id", type="integer", example="2")
 *    )
 * )
 *
 * Class CreateBeneficiaryRequest
 * @package App\Http\Requests\Beneficiary
 */
class CreateBeneficiaryRequest extends FormRequest
{
    protected function prepareForValidation()
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
            "code" => "required|string|min:1",
            "first_name" => "required|string|min:1",
            "last_name" => "required|string|min:1",
            "email" => "required|email",
            "profile" => "required|in:" . implode(",", Beneficiary::$PROFILES),
            "address_id" => "required|exists:addresses,id",
            "service_id" => "required|exists:services,id",
        ];
    }
}
