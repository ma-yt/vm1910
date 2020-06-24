<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\TokenModel;

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

            //保存token,后续验证使用
            $data = [
                'uid'=>$user->user_id,
                'token'=>$token
            ];

            TokenModel::insert($data);

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
    public function center(){

        //判断用户是否登录，判断是否有uid字段
        $token = $_GET['token'];

        //检验token是否有效
        $res = TokenModel::where(['token'=>$token])->first();

        if($token){
            $uid = $res->uid;
            $user_info = UserModel::find($uid);

            echo $user_info->user_name.'欢迎来到个人中心';
        }else{
            echo '请登录';
        }

    }
}
