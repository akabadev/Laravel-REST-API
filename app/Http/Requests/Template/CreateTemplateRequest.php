<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="CreateTemplateRequest",
 *     description="Create Template Request",
 *     required=true,
 *     @OA\JsonContent(
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="name", type="string", example="Nom"),
 *     @OA\Property(property="template_file", type="string", example="file.json")
 *    )
 * )
 *
 * Class CreateTemplateRequest
 * @package App\Http\Requests\Template
 */
class CreateTemplateRequest extends FormRequest
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
            "name" => "required|min:1|max:50|unique:templates,name",
            "code" => "required|alpha_num|min:1|max:50|unique:templates,code",
            "description" => "required|min:1|max:150",
            "template_file" => "required|min:1|max:150",
        ];
    }
}
