<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckPri
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');
        //验证token是否有效

        $tid = Redis::get($token);
        if(!$tid){
            $response = [
                'errno'=>500009,
                'msg'=>'鉴权失败'
            ];
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die;
        }

        return $next($request);
    }
}
