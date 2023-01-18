<?php

namespace App\Http\Requests\Format;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="CreateFormatRequest",
 *     description="Create Format Request",
 *     required=true,
 *     @OA\JsonContent(
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="name", type="string", example="Nom"),
 *     @OA\Property(property="config_file", type="string", example="file.json")
 *    )
 * )
 *
 * Class CreateFormatRequest
 * @package App\Http\Requests\Format
 */
class CreateFormatRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            "name" => Str::lower($this->name ?: ''),
            "code" => Str::lower($this->code ?: ''),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|min:1|max:50|unique:formats,name",
            "code" => "required|alpha_num|min:1|max:50|unique:formats,code",
            "description" => "required|min:1|max:150",
            "config_file" => "required|min:1|max:150",
        ];
    }
}
