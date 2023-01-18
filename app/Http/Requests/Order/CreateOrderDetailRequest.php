<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateOrderDetailRequest",
 *     description="Create Order Detail Request",
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
 * Class CreateOrderDetailRequest
 * @package App\Http\Requests\Order
 */
class CreateOrderDetailRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            "order_id" => $this->route("order")->id,
            "delivery_type" => "DEFAULT TYPE",
        ]);
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
            "quantity" => object_get(client_app()->configuration('order.json'), "details.quantity", 'required|int|min:1'),
            "delivery_type" => "required|string|min:5",
            "order_id" => "required|exists:orders,id",
            "product_id" => "required|exists:products,id",
            "beneficiary_id" => "required|exists:beneficiaries,id"
        ];
    }
}
