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
    //更改超级管理员密码
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
            $Validator = Validator::make($input, $rules, $message);

            if ($Validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if ($input['password_o'] == $_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return redirect('admin/info');
                }else{
                    return back()->with('errors', '原密码错误');
                }

            }else{
                return back()->withErrors($Validator);
            }

        }else {
            return view('admin.pass');
        }
    }
}
