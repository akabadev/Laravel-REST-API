<?php

namespace App\Http\Requests\Order;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateOrderRequest",
 *     description="Create Order Request",
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
 * Class CreateOrderRequest
 * @package App\Http\Requests\Order
 */
class CreateOrderRequest extends FormRequest
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
            "reference" => "required|alpha_num|min:5",
            "type" => "required|alpha_num|min:5",
            "tracking_number" => "required|alpha_num|min:5",
            "status" => "required|alpha_num|min:5",
            "customer_id" => "required|exists:customers,id",
        ];
    }
}
