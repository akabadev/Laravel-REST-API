<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\CanRespond;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use CanRespond;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function user(): Authenticatable|User|null
    {
        return Auth::guard('sanctum')->user();
    }
}
