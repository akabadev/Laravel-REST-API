<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     @OA\Xml(name="MenuPaylod"),
 * )
 *
 * @OA\RequestBody(
 *     request="CreateMenuRequest",
 *     description="Create Menu Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", description="User unique code", example="2456-MMM-88"),
 *         @OA\Property(property="name", type="string", description="Page name", example="Home"),
 *         @OA\Property(property="title", type="string", description="Page title", example="Home Page"),
 *         @OA\Property(property="sequence", type="integer", description="Page Order", example="1"),
 *         @OA\Property(property="active", type="boolean", description="Page Is active", example="true"),
 *         @OA\Property(property="profile_id", type="integer", description="Profile ID", example="1"),
 *         @OA\Property(property="view_id", type="integer", description="View ID", example="1"),
 *    )
 * )
 *
 * Class CreateMenuRequest
 * @package App\Http\Requests\Menu
 */
class CreateMenuRequest extends FormRequest
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
        $this->merge(["sequence" => intval($this->sequence ?: 1)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "profile_id" => "required|exists:profiles,id",
            "page_id" => "required|exists:pages,id",
            "title" => "string|min:5",
            "name" => "string|min:5",
            "sequence" => "int|min:1",
            "active" => "boolean",
            "payload" => "array",
            "payload.*.icon" => "required_with:payload|string",
            "payload.*.link" => "required_with:link|string",
        ];
    }
}
