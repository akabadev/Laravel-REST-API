<?php

namespace App\Http\Requests\Views\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateOrderViewRequest",
 *     description="Update Order View Request",
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
 * Class UpdateOrderViewRequest
 * @package App\Http\Requests\Views\Order
 */
class UpdateOrderViewRequest extends FormRequest
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
                "reference" => "alpha_num|min:5",
                "type" => "alpha_num|min:5",
                "tracking_number" => "alpha_num|min:5",
                "status" => "alpha_num|min:5",
                "customer_code" => "exists:customers,code",
            ],
        );
    }
}
