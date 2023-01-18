<?php

namespace App\Http\Requests\Views\Page;

use App\Http\Requests\Page\UpdatePageRequest;

/**
 * @OA\RequestBody(
 *     request="UpdatePageViewRequest",
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
class UpdatePageViewRequest extends UpdatePageRequest
{
    //
}
