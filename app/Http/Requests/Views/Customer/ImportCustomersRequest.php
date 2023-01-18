<?php

namespace App\Http\Requests\Views\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="ImportCustomersRequest",
 *     description="Import Customer (filetype: csv)",
 *     required=true,
 *     @OA\MediaType(
 *          mediaType="multipart/form-data",
 *          @OA\Schema(
 *              @OA\Property(property="file", type="file", format="binary")
 *          )
 *     )
 * )
 *
 * Class ImportCustomersRequest
 * @package App\Http\Requests\Views\Customer
 */
class ImportCustomersRequest extends FormRequest
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
