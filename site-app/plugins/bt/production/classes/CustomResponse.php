<?php

namespace Bt\Production\Classes;

class CustomResponse
{
    public static function api($status = 'success', $message = null, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}