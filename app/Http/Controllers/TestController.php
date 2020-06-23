<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{

    public function hello(){
        echo 123;
    }


    //redis测试
    public function redis1(){
        $key = 'name1';
        $val = Redis::get($key);
        var_dump($val);
        echo '$val:'.$val;
    }

}
