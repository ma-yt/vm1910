<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;

class AccessFilter
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
        $request_uri = $_SERVER['REQUEST_URI'];  //获取当前url
        $url_hash = substr(md5($request_uri),5,10);
        $max = env('API_ACCESS_MAX');  //接口最大访问次数
        $expire = env('API_ACCESS_TIMEOUT');  //触发防刷规则后  等待时间
        $time_last = env('API_ACCESS_TIME_LAST');  //接口访问的时间段
        $key = 'count_url_'.$url_hash;
        $total = Redis::get($key);  //后去访问次数

        if($total>$max){
            $response = [
                'errno'=>5000010,
                'msg'=>'请求过于频繁，请'.$expire.'秒后在试'
            ];
            //设置key的过期时间
            Redis::expire($key,$expire);
            return response()->json($response);
        }else{
            Redis::incr($key);
            Redis::expire($key,$time_last);  //获取某个时间段内的访问次数
        }

        return $next($request);
    }
}
