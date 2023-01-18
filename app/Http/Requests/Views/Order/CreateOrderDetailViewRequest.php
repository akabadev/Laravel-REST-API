<?php

namespace App\Http\Requests\Views\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateOrderDetailViewRequest",
 *     description="Create Order Detail View Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="quantity", type="integer", example="7"),
 *         @OA\Property(property="delivery_type", type="string", example="CARTE"),
 *         @OA\Property(property="product_code", type="string", example="CODE90909"),
 *         @OA\Property(property="beneficiary_code", type="integer", example="ID20920920")
 *    )
 * )
 *
 * Class CreateOrderViewRequest
 * @package App\Http\Requests\Views\Order
 */
class CreateOrderDetailViewRequest extends FormRequest
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
        $commonRules = collect(data_get(client_config("imports/orders.json"), "columns"))
            ->map(fn (array $column) => $column["validation"])
            ->toArray();

        return array_merge(
            $commonRules,
            [
                "quantity" => "required|int|min:1",
                "delivery_type" => "required|string|min:5",
                "product_code" => "required|exists:products,code",
                "beneficiary_code" => "required|exists:beneficiaries,code"
            ],
        );
    }
}
