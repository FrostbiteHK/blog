<?php
/**
 * Created by PhpStorm.
 * User: J95ha
 * Date: 2018/8/15
 * Time: 16:23
 */

namespace App\Http\Controllers\Admin; //注意更改命名空间

use App\Http\Controllers\Admin\CommonController;
use App\HTTP\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'C:\Users\J95ha\Desktop\blog\blog\resources\org\code\Code.class.php';

class LoginController extends CommonController
{
    public function login(){
        if ($input = Input::all()){
            if($input = Input::all()){
                $code = new \Code;
                $_code = $code->get();
                if(strtoupper($input['code']) != $_code){
                    return back()->with('msg','验证码错误!'); //返回当前页面
                }
                $user = User::first();
                if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass)!=$input['user_pass']){
                    return back()->with('msg','用户名或密码错误!');
                }

                session(['user' =>$user]);
                return redirect('admin/index');  //跳转到后台界面

            }

        }else{
            return view('admin.login');
        }

    }

    //验证码
    public function code(){
        $code = new \Code;
        $code ->  make();

    }


    public function quit(){
       session(['user'=>null]);
       return redirect('admin/login');
    }



}