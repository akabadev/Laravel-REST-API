<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateOrderDetailRequest",
 *     description="Update Order Detail Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="quantity", type="integer", example="3"),
 *         @OA\Property(property="delivery_type", type="string", example="Delivery Type"),
 *         @OA\Property(property="order_id", type="integer", example="1"),
 *         @OA\Property(property="product_id", type="integer", example="2"),
 *         @OA\Property(property="beneficiary_id", type="integer", example="3")
 *    )
 * )
 *
 * Class UpdateOrderDetailRequest
 * @package App\Http\Requests\Order
 */
class UpdateOrderDetailRequest extends FormRequest
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
            "quantity" => ["int", "min:1"],
            "delivery_type" => "string|min:5",
            "order_id" => "exists:orders,id",
            "product_id" => "exists:products,id",
            "beneficiary_id" => "exists:beneficiaries,id"
        ];
    }
}
