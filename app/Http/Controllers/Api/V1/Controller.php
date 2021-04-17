<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function responseOk(array $data)
    {
        return response()->json([
            'status' => 'ok',
            'message' => '',
            'data' => $data,
        ]);
    }

    public function responseError(string $message = '')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => [],
        ]);
    }
}
