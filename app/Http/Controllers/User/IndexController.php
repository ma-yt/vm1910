<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Cookie;

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
            return redirect('user/login');
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
            //setcookie('uid',$user->user_id,time()+3600,'/');
            //setcookie('name',$user->user_name,time()+3600,'/');
            Cookie::queue('uid2',$user->user_id,10);
            header("Refresh:1;url=/user/center");
            echo '登陆成功';
        }else{
            header("Refresh:1;url=/user/login");
            echo '登陆失败';
        }

    }


    public function center(){
        echo '<pre>';print_r($_COOKIE); echo'</pre>';
        $uid = Cookie::has('uid2');
        //var_dump($uid);

        if(Cookie::has('uid2')){

        }else{

        }
//        if(isset($_COOKIE['uid']) && isset($_COOKIE['name'])){
//            return view('user.center');
//        }else{
//            //echo '未登录';die;
//            return redirect('/user/login');
//        }
      //  return view('user/center');
    }
}
