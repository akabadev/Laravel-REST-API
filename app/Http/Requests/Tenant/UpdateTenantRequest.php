<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\RequestBody(
 *     request="UpdateTenantRequest",
 *     description="UpdateTenantRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="orange"),
 *         @OA\Property(property="image", type="file"),
 *     )
 * )
 *
 * Class UpdateTenantRequest
 * @package App\Http\Requests\Tenant
 */
class UpdateTenantRequest extends FormRequest
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
        $this->merge(['name' => Str::lower($this->get('name'))]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'regex:/^[a-zA-Z]+$/u|max:255|unique:tenants,id',
            'image' => 'file|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100' //,max_width=1000,max_height=1000
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Only letters is allowed'
        ];
    }
}
