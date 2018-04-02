<?php
namespace App\Transformers;
class Json
{
    public static function response($status = 0, $message = null, $data = null)
    {
        return [
        	'status' => $status, 
            'message' => $message,
            'data' => $data,
        ];
    }
}