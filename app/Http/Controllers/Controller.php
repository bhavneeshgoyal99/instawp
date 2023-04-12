<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function apiSuccess($data = [], $message = "Successfull", $status = 200){
        $repsonse = [
            'status' => $status,
            'success' => true,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($repsonse);
    }

    public function apiFailure($message = "Error", $status = 400){
        $repsonse = [
            'status' => $status,
            'success' => false,
            'message' => $message,
        ];

        return response()->json($repsonse);
    }
}
