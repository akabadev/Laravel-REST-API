<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateListingRequest",
 *     description="Create Listing Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="2628772687"),
 *         @OA\Property(property="parent_id", type="integer", example="1"),
 *         @OA\Property(property="description", type="string", example="description text"),
 *         @OA\Property(property="notion", type="string", example="MorphToClass"),
 *    )
 * )
 *
 * Class CreateListingRequest
 * @package App\Http\Requests\Listing
 */
class CreateListingRequest extends FormRequest
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
            "code" => "required|alpha_num|min:1",
            "parent_id" => "exists:listings,id",
            "description" => "required|string",
            "notion" => "required|string"
        ];
    }
}
