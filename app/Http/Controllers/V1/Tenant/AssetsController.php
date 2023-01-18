<?php

namespace App\Http\Controllers\V1\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssetsController extends Controller
{
    /**
     * @OA\Get (
     *     path="/{tenant}/api/v1/assets/{type}/{file}",
     *     summary="Getting assets file",
     *     description="Getting assets file from current tenant, if not found then we get it from the default tenant",
     *     tags={"assets"},
     *     @OA\Parameter(ref="#/components/parameters/tenant"),
     *     @OA\Parameter(
     *          name="type",
     *          description="Assets type css, js, img",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="file",
     *          description="File path in tenant public folder",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param string $folder
     * @param string $file
     * @return BinaryFileResponse | Response
     */
    public function __invoke(string $folder, string $file): BinaryFileResponse|Response
    {
        $filePath = $this->getRequestedAssetPath($folder, $file);

        abort_if(
            !file_exists($filePath),
            Response::HTTP_NOT_FOUND,
            "Could not find the asset file <$file>"
        );

        return response()->file($filePath);
    }

    /**
     * @param string $folder
     * @param string $assetPath
     * @return string
     */
    private function getRequestedAssetPath(string $folder, string $assetPath): string
    {
        abort_if(
            !in_array($folder, ["css", "js", "img"]),
            Response::HTTP_NOT_FOUND,
            "Type Error: <$folder> not supported"
        );

        $filePath = normalize_path(client_path("public/$folder/$assetPath"));

        if (file_exists($filePath)) {
            return $filePath;
        }

        return normalize_path(client_path("public/$assetPath", true));
    }
}
