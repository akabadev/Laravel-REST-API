<?php

namespace App\Http\Requests\Views\Beneficiary;

use App\Models\Beneficiary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="CreateBeneficiaryViewRequest",
 *     description="Create Beneficiary View Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="first_name", type="string", example="John"),
 *         @OA\Property(property="last_name", type="string", example="Doe"),
 *         @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *         @OA\Property(property="address_id", type="integer", example="1"),
 *         @OA\Property(property="service_id", type="integer", example="2"),
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
class CreateBeneficiaryViewRequest extends FormRequest
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
        $filter = on_param(
            'beneficiary.address',
            fn () => fn () => true,
            fn () => fn ($_, $key) => !Str::startsWith($key, 'address')
        );

        return collect(data_get(client_config('imports/beneficiaries.json'), 'columns'))
            ->map(fn (array $column) => $column['validation'])
            ->put("profile", 'required|in:' . implode(',', Beneficiary::$PROFILES))
            ->put("address", "required|array")
            ->filter($filter)
            ->toArray();
    }
}
