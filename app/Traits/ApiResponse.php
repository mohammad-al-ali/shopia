<?php

namespace App\Traits;

trait ApiResponse
{
static function apiResponse($data=null,$msg=null,$status=201){
    $res = [
                    'data'=>$data,
                    'msg'=>$msg,
                    'status'=>$status,
                ];
    return response()->json($res);

}
}
