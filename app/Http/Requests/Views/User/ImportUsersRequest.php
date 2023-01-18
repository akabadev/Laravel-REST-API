<?php

namespace App\Http\Requests\Views\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="ImportUsersRequest",
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
class ImportUsersRequest extends FormRequest
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
