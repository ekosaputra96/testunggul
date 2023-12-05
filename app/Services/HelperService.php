<?php

namespace App\Services;

class HelperService {
    public function successResponse($message, $data){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function failedResponse($message, $code = 400){
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}