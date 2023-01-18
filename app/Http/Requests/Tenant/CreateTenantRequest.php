<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="CreateTenantRequest",
 *     description="CreateTenantRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="array", example="[]", @OA\Items()),
 *         @OA\Property(property="template_id", type="integer", example="1"),
 *         @OA\Property(property="image", type="file"),
 *     )
 * )
 *
 * Class CreateTenantRequest
 * @package App\Http\Requests\Tenant
 */
class CreateTenantRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge(["name" => Str::lower($this->get("name"))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => "required|regex:/^[a-zA-Z]+$/u|max:255|unique:tenants,id",
            "image" => "required|file|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100", // ,max_width=1000,max_height=1000
            // "tenant_model" => "string|exists:tenants,id",
            "template_id" => "required_without:tenant_model|int|exists:templates,id",
        ];
    }

    public function messages()
    {
        return [
            "name.regex" => "Only letters are allowed",
            "tenant_model" => "Tenant model should be the id of an existing tenant"
        ];
    }
}
