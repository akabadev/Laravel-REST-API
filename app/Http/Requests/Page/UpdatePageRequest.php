<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdatePageRequest",
 *     description="Update Page Request",
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
 * Class UpdateViewRequest
 * @package App\Http\Requests\View
 */
class UpdatePageRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => "string|min:5",
            "title" => "string|min:5",
            "description" => "string",
            "active" => "boolean",
            'code' => 'string|min:5'
        ];
    }
}
