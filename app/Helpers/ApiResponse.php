<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($message = 'Success', $data = null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public static function error($message = 'Error', $data = null, $code = 404)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public static function already($message = 'Success', $data = null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
