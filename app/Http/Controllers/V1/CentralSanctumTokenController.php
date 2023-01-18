<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Token\CreateTokenRequest;
use App\Http\Requests\Token\UpdateTokenRequest;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class CentralSanctumTokenController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PersonalAccessToken::class, "token");
    }

    /**
     * @OA\Get (
     *     path="/main/api/v1/tokens",
     *     summary="Display a listing of the resource.",
     *     description="Display a listing of the resource.",
     *     tags={"central/tokens"},
     *
     *     @OA\RequestBody(description="Client side search object", required=false, @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object"
     *                  )
     *              ),
     *              @OA\Property(property="current_page", type="integer"),
     *              @OA\Property(property="to", type="integer"),
     *              @OA\Property(property="total", type="integer"),
     *              @OA\Property(property="path", type="string"),
     *              @OA\Property(property="next_page_url", type="string"),
     *              @OA\Property(property="prev_page_url", type="string"),
     *          )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(PersonalAccessToken::generated()->paginate());
    }

    /**
     * @OA\Post  (
     *     path="/main/api/v1/tokens",
     *     summary="Store a newly created resource in storage",
     *     description="Store a newly created resource in storage",
     *     tags={"central/tokens"},
     *     @OA\RequestBody(
     *         description="New Address Data",
     *         required=false,
     *         @OA\MediaType(mediaType="application/json"),
     *         required=true
     *     ),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param CreateTokenRequest $request
     * @return JsonResponse
     */
    public function store(CreateTokenRequest $request): JsonResponse
    {
        [
            "user_id" => $userId,
            "abilities" => $abilities,
            "name" => $name
        ] = $request->validated();

        /** @var User $user */
        $user = User::findOrFail($userId);

        $token = $user->createToken($name, $abilities);

        $data = [
            "user" => $user,
            "name" => $token->accessToken->name,
            "abilities" => $token->accessToken->abilities,
            "id" => $token->accessToken->id,
            "token" => $token->plainTextToken
        ];

        return $this->successResponse($data, 'Take care of this token. The token is only given once');
    }

    /**
     * Display the specified resource.
     * @OA\Get  (
     *     path="/main/api/v1/tokens/{token}",
     *     summary="Display the specified resource",
     *     description="Display the specified resource",
     *     tags={"central/tokens"},
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function show(PersonalAccessToken $token): JsonResponse
    {
        return $this->successResponse($token);
    }

    /**
     * @OA\Patch (
     *     path="/main/api/v1/tokens/{token}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/tokens"},
     *     @OA\RequestBody(required=true),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @OA\Put (
     *     path="/main/api/v1/tokens/{token}",
     *     summary="Update the specified resource in storage",
     *     description="Update the specified resource in storage",
     *     tags={"central/tokens"},
     *     @OA\RequestBody(required=true),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param UpdateTokenRequest $request
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function update(UpdateTokenRequest $request, PersonalAccessToken $token): JsonResponse
    {
        $token->update($request->validated());
        return $this->successResponse($token->refresh());
    }

    /**
     * @OA\Delete (
     *     path="/main/api/v1/tokens/{token}",
     *     summary="Remove the specified resource from storage",
     *     description="Remove the specified resource from storage",
     *     tags={"central/tokens"},
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=400, description="Bad Request"),
     *     @OA\Response(response=404, description="not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     *
     * @param PersonalAccessToken $token
     * @return JsonResponse
     */
    public function destroy(PersonalAccessToken $token): JsonResponse
    {
        return $this->successResponse($token->delete());
    }
}
