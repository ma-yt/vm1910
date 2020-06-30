<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/hello','TestController@hello');
Route::get('/test/redis1','TestController@redis1');



//商品
Route::get('/goods/deatil','Goods\GoodsController@deatil');


Route::get('user/reg','User\IndexController@reg');
Route::post('user/regdo','User\IndexController@regdo');
Route::get('user/login','User\IndexController@login');
Route::post('user/logindo','User\IndexController@logindo');
Route::get('user/center','User\IndexController@center');


Route::post('/api/user/reg','Api\UserController@regdo');    //注册
Route::post('/api/user/login','Api\UserController@logindo');    //登录
Route::get('/api/user/center','Api\UserController@center')->middleware('check.pri');     //个人中心
Route::get('/api/my/orders','Api\UserController@orders')->middleware('check.pri');     //我的订单
Route::get('/api/my/cart','Api\UserController@cart')->middleware('check.pri');   //购物车


//路由分组
Route::middleware('check.pri','access.filter')->group(function(){
    Route::get('/api/a','Api\TestController@a');
    Route::get('/api/b','Api\TestController@b');
    Route::get('/api/c','Api\TestController@c');
    Route::get('/api/x','Api\TestController@x');
    Route::get('/api/y','Api\TestController@y');
    Route::get('/api/z','Api\TestController@z');
});