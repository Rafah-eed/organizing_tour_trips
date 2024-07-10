<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function getResponse(bool $result, string $message, $data = null, $code = 200, string $exception = null)
    {
        $res = [
            'result' => $result,
            'message' => $message
        ];
        if ($data !== null) {
            $res['data'] = $data;
        }
        if ($exception !== null) {
            $res['exception'] = $exception;
        }
        return response()->json($res, $code);
    }
}
