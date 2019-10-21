<?php

namespace App\Common;

class CustomResponse
{
    
    public function sendResponse($response)
    {
        if (array_key_exists('data', $response)){
            return response()->json([
                'data' => $response['data'],
                'message' => $response['message'],
            ], $response['status']);
        } elseif (array_key_exists('errors', $response)) {
            return response()->json([
                'errors' => $response['errors'],
                'message' => $response['message'],
            ], $response['status']);
        } else {
            return response()->json([
                'message' => $response['message'],
            ], $response['status']);
        }
    }
    
    public function getErrorResponse($errors, $message, $status = 406)
    {
        return [
            'errors' =>  $errors,
            'message' => $message,
            'status' => $status
        ];
    }
    public function getSuccessResponse($data, $message, $status = 200)
    {
        return [
            'data' =>  $data,
            'message' => $message,
            'status' => $status
        ];
    }
}
