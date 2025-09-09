<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    // keep your other code (report(), etc)

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            return response()->json([
                'success' => false,
                'message' => 'आपको यह कार्य करने की अनुमति नहीं है।',
                'status' => 403,
            ], 403);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'success' => false,
                'message' => 'आप इस क्रिया को करने के लिए अधिकृत नहीं हैं।',
                'status' => 403,
            ], 403);
        }

        return parent::render($request, $exception);
    }
}
