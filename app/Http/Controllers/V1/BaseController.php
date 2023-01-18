<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(title="Logiweb by Up", version="1.0.0")
 *
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="main", parameter="main", content="main")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="tenant", parameter="tenant")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="customer", parameter="customer")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="user", parameter="user")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="address", parameter="address")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="beneficiary", parameter="beneficiary")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="listing", parameter="listing")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="order", parameter="order")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="detail", parameter="detail")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="token", parameter="token")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="process", parameter="process")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="product", parameter="product")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="service", parameter="service")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="task", parameter="task")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="tenant-template", parameter="tenant_template")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="format", parameter="format")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="template", parameter="template")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="calendar", parameter="calendar")
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="period", parameter="period"),
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="profile", parameter="profile"),
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="view", parameter="page"),
 * @OA\Parameter(@OA\Schema(type="string"), required=true, in="path", allowReserved=true, name="menu", parameter="menu")
 */
abstract class BaseController extends Controller
{
    use AuthorizesRequests {
        resourceAbilityMap as protected parentResourceAbilityMap;
        resourceMethodsWithoutModels as protected parentResourceMethodsWithoutModels;
    }

    /**
     * @return array
     */
    protected function resourceAbilityMap(): array
    {
        return array_merge(
            $this->parentResourceAbilityMap(),
            ["restore" => "restore"]
        );
    }

    /**
     * @return array
     */
    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(
            $this->parentResourceMethodsWithoutModels(),
            ["restore"]
        );
    }
}
