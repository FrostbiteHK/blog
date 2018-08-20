<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use \Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    //get.admin/category 全部分类列表
    public function index(){
        //categorys = Category::tree(); 使用第一种方法
        $categorys = (new Category)->tree();
        return view('admin.category.index')->with('data' ,$categorys);
    }



    //get.admin/category/create 添加分类
    public function create(){
        $data = Category::where('cate_pid', 0)->get();
        return view('admin/category/add',compact('data'));//使用compact方法传输数据
    }
    //post.admin/category  添加分类提交
    public function store(){
        $input = Input::all();

        //数据验证功能
        if($input= Input::except('_token')) {
            //except获取除token外的所有数据
            $rules = [
                'cate_name' => 'required', //非空
            ];

            $message = [
                'cate_name.required' => '分类名称不能为空',

            ];
            $Validator = Validator::make($input, $rules, $message); //Validator 提供表单验证功能，make()方法 第一个参数被验证的数据名称，第二个参数为规则，第三个参数为错误提示

            if ($Validator->passes()) {  //执行验证并判断验证是否成功
                $re = Category::create($input);
                if($re){
                    return redirect('admin/category');
                }
            } else {
                return back()->with('errors', '数据填充失败，请稍后重试'); //返回错误信息
            }
            dd($input);
        }
    }

    //get.admin/category/{category} 显示单个分类信息
    public function show(){

    }

    //delete.admin/category/{category} 删除单个分类
    public function destroy($cate_id){
//        $re = Category::delete($cate_id); 错误实例 delete方法不能带参数
          $re = Category::where('cate_id',$cate_id)->delete();
          Category::where('cate_pid', $cate_id)->update(['cate_pid' => 0]); //删除顶级分类，子分类升为顶级分类
          if($re){
              $data = [
                'status' => 0,
                'msg' => '分类删除成功'
              ];
          }else{
              $data = [
                  'status' => 1,
                  'msg' => '分类删除失败，请重试'
              ];
          }
          return $data;
    }

    //get.admin/category/{category}/edit 编辑分类
    public function edit($cate_id){
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.edit', compact('field', 'data'));
    }

    //put.admin/category/{category} 更新分类
    public function update($cate_id){
        $input = Input::except('_token','_method');
        $re =Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors', '分类信息更新失败，请稍后重试');
        }
    }

    //异步更新文章排序
    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re) {
            $data = [
                'status' => 0,
                'msg' => '更新成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '更新失败,请重试',
            ];}
        return $data;
        }


}
