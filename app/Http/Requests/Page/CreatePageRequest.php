<?php

namespace App\Http\Requests\Page;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreatePageRequest",
 *     description="Create Page Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", description="User unique code", example="2456-MMM-88"),
 *         @OA\Property(property="name", type="string", description="Page name", example="Home"),
 *         @OA\Property(property="title", type="string", description="Page title", example="Home Page"),
 *         @OA\Property(property="description", type="string", description="Page Description", example="Home Page Description"),
 *         @OA\Property(property="sequence", type="integer", description="Page Order", example="1"),
 *         @OA\Property(property="active", type="boolean", description="Page Is active", example="true")
 *    )
 * )
 *
 * Class CreateViewRequest
 * @package App\Http\Requests\View
 */
class CreatePageRequest extends FormRequest
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
        $this->merge(["code" => $this->code ?? Page::freshCode()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "code" => "required|string|min:5",
            "name" => "required|string|min:5",
            "description" => "string",
            "active" => "boolean",
        ];
    }
}
