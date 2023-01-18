<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateMenuRequest",
 *     description="Update Menu Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", description="User unique code", example="2456-MMM-88"),
 *         @OA\Property(property="name", type="string", description="Page name", example="Home"),
 *         @OA\Property(property="title", type="string", description="Page title", example="Home Page"),
 *         @OA\Property(property="sequence", type="integer", description="Page Order", example="1"),
 *         @OA\Property(property="active", type="boolean", description="Page Is active", example="true"),
 *    )
 * )
 *
 * Class UpdateMenuRequest
 * @package App\Http\Requests\Menu
 */
class UpdateMenuRequest extends FormRequest
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
            "sequence" => "int|min:1",
            "active" => "boolean",
            "payload" => "array",
            "payload.*.icon" => "string",
            "payload.*.link" => "string",
        ];
    }
}
