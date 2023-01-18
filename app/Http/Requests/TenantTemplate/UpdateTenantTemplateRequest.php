<?php

namespace App\Http\Requests\TenantTemplate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="UpdateTenantTemplateRequest",
 *     description="UpdateTenantTemplateRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="Template name")
 *     )
 * )
 *
 * Class UpdateTenantTemplateRequest
 * @package App\Http\Requests\TenantTemplate
 */
class UpdateTenantTemplateRequest extends FormRequest
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
        $this->merge(['name' => Str::lower($this->name)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'unique:tenant_templates,name'
        ];
    }
}
