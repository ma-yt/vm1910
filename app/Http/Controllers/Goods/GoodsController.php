<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    public function deatil(){
        $goods_id = $_GET['id'];  //接受url的get参数id
        echo 'goods_id'.$goods_id;echo '<br/>';


        //查询详情
        //$goods = GoodsModel::where(['goods_id'=>$goods_id])->first()->toArray();
        $goods = GoodsModel::find($goods_id);
        echo '<pre>';print_r($goods);echo '</pre>';
    }
}
