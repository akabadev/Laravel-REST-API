<?php

namespace App\Http\Requests\Format;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateFormatRequest",
 *     description="Update Format Request",
 *     required=true,
 *     @OA\JsonContent(
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="name", type="string", example="Nom"),
 *     @OA\Property(property="config_file", type="string", example="file.json")
 *    )
 * )
 *
 * Class UpdateFormatRequest
 * @package App\Http\Requests\Format
 */
class UpdateFormatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $format = $this->route('format');
        return [
            "name" => "min:1|max:50|unique:formats,name",
            "code" => "alpha_num|min:1|max:50|unique:formats,code,$format->id",
            "description" => "min:1|max:150",
            "config_file" => "min:1|max:150",
        ];
    }
}
