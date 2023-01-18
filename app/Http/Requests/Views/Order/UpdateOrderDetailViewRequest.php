<?php

namespace App\Http\Requests\Views\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateOrderDetailViewRequest",
 *     description="Update Order Detail View Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="quantity", type="integer", example="7"),
 *         @OA\Property(property="delivery_type", type="string", example="CARTE"),
 *         @OA\Property(property="product_code", type="string", example="CODE90909"),
 *         @OA\Property(property="beneficiary_code", type="integer", example="ID20920920")
 *    )
 * )
 *
 * Class UpdateOrderDetailViewRequest
 * @package App\Http\Requests\Views\Order
 */
class UpdateOrderDetailViewRequest extends FormRequest
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
        $this->merge([
            "active" => filter_var($this->active, FILTER_VALIDATE_BOOLEAN)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $commonRules = collect(data_get(client_config("imports/orders.json"), "columns"))
            ->map(fn (array $column) => $column["validation"])
            ->toArray();

        return array_merge(
            $commonRules,
            [
                "quantity" => "int|min:1",
                "delivery_type" => "string|min:5",
                "product_code" => "exists:products,code",
                "beneficiary_code" => "exists:beneficiaries,code",
                "active" => "boolean"
            ],
        );
    }
}
