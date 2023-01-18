<?php

namespace App\Http\Requests\Views\Service;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="ImportServicesRequest",
 *     description="Import Services (filetype: csv)",
 *     required=true,
 *     @OA\MediaType(
 *          mediaType="multipart/form-data",
 *          @OA\Schema(
 *              @OA\Property(property="file", type="file", format="binary")
 *          )
 *     )
 * )
 *
 * Class ImportServicesRequest
 * @package App\Http\Requests\Views\Service
 */
class ImportServicesRequest extends FormRequest
{

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
