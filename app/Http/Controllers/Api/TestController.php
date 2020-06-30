<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function a(){
        $request_uri = $_SERVER['REQUEST_URI'];
        $uri_hash = substr(md5($request_uri),5,10);
        $expire = 10;  //n秒后重试时间

        $key = 'access_total_'.$uri_hash;


        $total = Redis::incr($key);  //获取访问次数

        if($total>10){
            echo '请求过于频繁，请'.$expire.'秒后再试';
            //设置key的过期时间
            Redis::expire($key,10);
        }else{
            Redis::incr($key);
            echo '当前访问次数位:'.$total;
        }

    }

    public function b(){

        echo __METHOD__;
//        $key = 'access_total_b';
//        $total = Redis::incr($key);
//
//        if($total>10){
//            echo '请求过于频繁，请稍后再试';
//        }else{
//            echo '当前访问次数位:'.$total;
//        }
    }

    public function c(){
        echo __METHOD__;
//        $key = 'access_total_c';
//        $total = Redis::incr($key);
//
//        if($total>10){
//            echo '请求过于频繁，请稍后再试';
//        }else{
//            echo '当前访问次数位:'.$total;
//        }
    }

    public function x(){
        echo __METHOD__;
    }

    public function y(){
        echo __METHOD__;
    }

    public function z(){
        echo __METHOD__;
    }
}
