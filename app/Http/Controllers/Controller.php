<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function handleResponse($data, $msg = null, $code = 200)
    {
    	$response = [
            'success' => true,
            'data'    => $data,
            'message' => $msg,
        ];
        return response()->json($response, $code);
    }

    public function handleError($error, $errorMsg = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMsg)){
            $response['data'] = $errorMsg;
        }
        return response()->json($response, $code);
    }
}
