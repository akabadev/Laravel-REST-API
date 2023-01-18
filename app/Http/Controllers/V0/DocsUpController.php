<?php

namespace App\Http\Controllers\V0;

use App\Http\Controllers\Controller;
use App\Http\Utils\ForwardLogiwebApiCallTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class DocsUpController extends Controller
{
    use ForwardLogiwebApiCallTrait;

    /**
     * @return Response|JsonResponse|\Illuminate\Http\Client\Response
     * @throws Throwable
     */
    public function __invoke(): Response|JsonResponse|\Illuminate\Http\Client\Response
    {
        return $this->forwardGetCall(null, null);
    }

    protected function targetFile(): string
    {
        return 'docup.php';
    }
}
