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