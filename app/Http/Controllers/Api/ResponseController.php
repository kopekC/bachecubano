<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class ResponseController extends Controller
{
    /**
     * Last method for a response data
     */
    public function sendResponse($response)
    {
        return response()->json($response, 200);
    }

    /**
     * Used for default error reporting via API
     */
    public function sendError($error, $code = 404)
    {
        $response = [
            'error' => $error,
        ];
        return response()->json($response, $code);
    }
}
