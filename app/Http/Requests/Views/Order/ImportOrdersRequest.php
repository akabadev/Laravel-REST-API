<?php

namespace App\Http\Requests\Views\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="ImportOrdersRequest",
 *     description="Import Orders (filetype: csv)",
 *     required=true,
 *     @OA\MediaType(
 *          mediaType="multipart/form-data",
 *          @OA\Schema(
 *              @OA\Property(property="file", type="file", format="binary")
 *          )
 *     )
 * )
 *
 * Class ImportOrdersRequest
 * @package App\Http\Requests\Views\Order
 */
class ImportOrdersRequest extends FormRequest
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
            'file' => 'required|file|mimes:csv,txt'
        ];
    }
}
