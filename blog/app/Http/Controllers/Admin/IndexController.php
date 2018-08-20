<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\HTTP\Model\User;
use Illuminate\Support\Facades\Crypt;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index(){
      return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }
    //更改超级管理员密码，操作pass.blade.php
    public function pass(){
        if($input= Input::all()){
            $rules = [
              'password'=> 'required|between:6,20|confirmed', //新密码非空,6-20位,两次一致
            ];

            $message = [
                'password.required' => '新密码不能为空',
                'password.between' => '新密码为6-20位之间',
                'password.confirmed' => '两次密码不一致',
            ];
            $Validator = Validator::make($input, $rules, $message); //Validator 提供表单验证功能，make()方法 第一个参数被验证的数据名称，第二个参数为规则，第三个参数为错误提示

            if ($Validator->passes()){  //执行验证并判断验证是否成功
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if ($input['password_o'] == $_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors', '密码修改成功！');
                }else{
                    return back()->with('errors', '原密码错误！');
                }

            }else{
                return back()->withErrors($Validator); //返回错误信息
            }

        }else {
            return view('admin.pass');
        }
    }
}
