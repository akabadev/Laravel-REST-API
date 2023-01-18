<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateTemplateRequest",
 *     description="Update Template Request",
 *     required=true,
 *     @OA\JsonContent(
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="name", type="string", example="Nom"),
 *     @OA\Property(property="template_file", type="string", example="file.json")
 *    )
 * )
 *
 * Class UpdateTemplateRequest
 * @package App\Http\Requests\Template
 */
class UpdateTemplateRequest extends FormRequest
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
        $template = $this->route('template');
        return [
            "name" => "min:1|max:50|unique:templates,name",
            "code" => "alpha_num|min:1|max:50|unique:templates,code,$template->id",
            "description" => "min:1|max:150",
            "template_file" => "min:1|max:150",
        ];
    }
}
