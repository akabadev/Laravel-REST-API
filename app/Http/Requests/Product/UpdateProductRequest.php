<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateProductRequest",
 *     description="Update Product Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="92879827-UII"),
 *         @OA\Property(property="name", type="string", example="Name"),
 *         @OA\Property(property="price", type="double", example="25.5"),
 *         @OA\Property(property="price_share", type="double", example="2.5")
 *    )
 * )
 *
 * Class UpdateProductRequest
 * @package App\Http\Requests\Product
 */
class UpdateProductRequest extends FormRequest
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
            "code" => "alpha_num|min:5",
            "name" => "alpha_num|min:5",
            "price" => "numeric|min:1",
            "price_share" => "numeric|min:0",
        ];
    }
}
