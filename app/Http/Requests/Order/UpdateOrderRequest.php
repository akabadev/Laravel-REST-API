<?php

namespace App\Http\Requests\Order;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateOrderRequest",
 *     description="Update Order Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="reference", type="string", example="92879827-UII"),
 *         @OA\Property(property="type", type="string", example="Type"),
 *         @OA\Property(property="tracking_number", type="string", example="John Doe"),
 *         @OA\Property(property="status", type="string"),
 *         @OA\Property(property="customer_id", type="integer", example="1")
 *    )
 * )
 *
 * Class UpdateOrderRequest
 * @package App\Http\Requests\Order
 */
class UpdateOrderRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $customer = Customer::firstOrFail();
        $this->merge(["customer_id" => $customer->id]);
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
            "reference" => "alpha_num|min:5",
            "type" => "alpha_num|min:5",
            "tracking_number" => "alpha_num|min:5",
            "status" => "alpha_num|min:5",
            "customer_id" => "exists:customers,id",
        ];
    }
}
