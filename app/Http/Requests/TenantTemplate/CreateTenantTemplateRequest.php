<?php

namespace App\Http\Requests\TenantTemplate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="CreateTenantTemplateRequest",
 *     description="CreateTenantTemplateRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="Tenant Template name")
 *     )
 * )
 *
 * Class CreateTenantTemplateRequest
 * @package App\Http\Requests\TenantTemplate
 */
class CreateTenantTemplateRequest extends FormRequest
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
            'name' => 'required|unique:tenant_templates,name'
        ];
    }
}
