<?php

namespace App\Http\Requests\Views\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateOrderViewRequest",
 *     description="Create Order View Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="reference", type="string", example="REF-7267267262-29829"),
 *         @OA\Property(property="type", type="string", example="CARTE"),
 *         @OA\Property(property="tracking_number", type="string", example="2345678-GHNB-34567"),
 *         @OA\Property(property="status", type="integer", example="EN COURS"),
 *         @OA\Property(property="customer_code", type="integer", example="CODE09092")
 *    )
 * )
 *
 * Class CreateOrderViewRequest
 * @package App\Http\Requests\Views\Order
 */
class CreateOrderViewRequest extends FormRequest
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
                "reference" => "required|alpha_num|min:5",
                "type" => "required|alpha_num|min:5",
                "tracking_number" => "required|alpha_num|min:1",
                "status" => "required|string|min:1",
                "customer_code" => "required|exists:customers,code",

                "details" => "array",
                "details.*.quantity" => "required_with:details|int|min:1",
                "details.*.delivery_type" => "required_with:details|string|min:5",
                "details.*.product_code" => "required_with:details|exists:products,code",
                "details.*.beneficiary_code" => "required_with:details|exists:beneficiaries,code"
            ],
        );
    }
}
