<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function response($result, $message = [])
    {
        $responce = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($responce, 200);
    }

    public function error($error, $errorMessages = [], $code = 404)
    {
        $responce = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)) {
            $responce['data'] = $errorMessages;
        }

        return response()->json($responce, $code);
    }
}
