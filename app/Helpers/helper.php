<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('customResponse')) {

    function customResponse($data = [], $code = 200, $error = "")
    {
        return response()->json([
            'data'  => $data,
            'code'  => $code,
            'error' => $error
        ], $code);
    }
}

