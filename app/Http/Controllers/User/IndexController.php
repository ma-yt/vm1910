<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;

class IndexController extends Controller
{
    public function reg(){
        return view('user/reg');
    }

    public function regdo(Request $request){
        $user_name = request()->post('user_name');
        $name = UserModel::where('user_name',$user_name)->first();
        if($name){
            die('用户名已存在');
        }

        $email = request()->post('email');
        $email = UserModel::where('email',$email)->first();
        if($email){
            die('邮箱已存在');
        }

        $password = request()->post('password');
        $pass1 = request()->input('password1');
        if($password!=$pass1){
            die('密码不一致,请从新输入');
        }

        $data = request()->except('_token','password1');
        $data['password'] = password_hash($password,PASSWORD_DEFAULT);
        $user = UserModel::insert($data);
        if($user){
                redirect('user/login');
        }
    }

    public function login(){
        return view('user/login');
    }

    public function logindo(){
        $user_name = request()->post('user_name');
        $password = request()->post('password');
        $user = UserModel::where(['user_name'=>$user_name])->first();
        $res = password_verify($password,$user->password);
        if($res){
            header("Refresh:1;url=/user/center");
            echo '登陆成功';
        }else{
            header("Refresh:1;url=/user/login");
            echo '登陆失败';
        }

    }
}
