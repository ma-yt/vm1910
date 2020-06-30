<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function regdo(Request $request){
        //echo '<pre>';print_r($_POST);echo '</pre>';die;
        $user_name = request()->post('user_name');
        $name = UserModel::where('user_name',$user_name)->first();
        if($name){
            $response = [
                'error'=>'500001',
                'msg'=>'用户名已存在'
            ];
            return $response;
        }

        $email = request()->post('email');
        $email = UserModel::where('email',$email)->first();
        if($email){
            $response = [
                'error'=>'500002',
                'msg'=>'邮箱已存在'
            ];
            return $response;
        }

        $password = request()->post('password');
        $pass1 = request()->input('password1');
        if($password!=$pass1){
            $response = [
                'error'=>'500003',
                'msg'=>'密码不一致,请从新输入'
            ];
            return $response;
        }

        $data = request()->except('_token','password1');
        $data['password'] = password_hash($password,PASSWORD_DEFAULT);
        $user = UserModel::insert($data);
        if($user){
            $response = [
                'error'=>'500003',
                'msg'=>'注册成功'
            ];
            return $response;
        }else{
            $response = [
                'error'=>'500004',
                'msg'=>'注册失败'
            ];
            return $response;
        }

    }

    //登录接口
    public function logindo(Request $request){
        $user_name = request()->post('user_name');
        $password = request()->post('password');

        $user = UserModel::where(['user_name'=>$user_name])->first();

        $res = password_verify($password,$user->password);
        if($res){

            //生成token
            $str = $user->user_id.$user->user_name.time();
            $token = substr(md5($str),10,16).substr(md5($str),0,10);


            //将token保存到redis中
            Redis::set($token,$user->user_id);

            //设置key的过期时间

            $data = [
                'uid'=>1234,
                'token'=>$token,
                'expire'=>time()+7200,
            ];

            $response = [
                'error'=>0,
                'msg'=>'ok',
                'token'=>$token
            ];
        }else{
            $response = [
                'error'=>500005,
                'msg'=>'登录失败',
            ];
        }
        return $response;

    }

    //个人中心
    public function center(Request $request){

        $token = $request->input('token');
        $tid = Redis::get($token);

        if($tid){
            $user_info = UserModel::find($tid);

            echo $user_info->user_name.'欢迎来到个人中心';
        }else{
            echo '请登录';
        }

    }


    //我的订单
    public function orders(){



        $arr = [
            '1234567890',
            '1234567891',
            '0987654321',
            '10987654321'
        ];

        $response = [
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'orders'=>$arr
            ]
        ];
        return $response;
    }


    //购物车
    public function cart(){

        $goods = [
            123,
            456,
            789
        ];

        $response = [
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'cart'=>$goods
            ]
        ];
        return $response;
    }
}
