<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    public function hello(){
        echo 123;
        echo date('Y-m-d H:i:s');
    }
}
