<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateListingRequest",
 *     description="Update Listing Request",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="code", type="string", example="2628772687"),
 *         @OA\Property(property="parent_id", type="integer", example="1"),
 *         @OA\Property(property="description", type="string", example="description text"),
 *         @OA\Property(property="notion", type="string", example="MorphToClass"),
 *    )
 * )
 *
 * Class UpdateListingRequest
 * @package App\Http\Requests\Listing
 */
class UpdateListingRequest extends FormRequest
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
            "code" => "alpha_num|min:1",
            "parent_id" => "exists:listings,id",
            "description" => "string",
            "notion" => "string"
        ];
    }
}
