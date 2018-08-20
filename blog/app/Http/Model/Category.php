<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'blog_category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];


//    public static function tree()  第一种方法
//    {
//        $categorys = Category::all();
//        return (new Category)->getTree($categorys, 'cate_name','cate_id', 'cate_pid');
//    }

    public function tree()  //第二种方法
    {
        $categorys = $this->orderBy('cate_order', 'asc')->get();  //排序功能
        return $this->getTree($categorys, 'cate_name', 'cate_id', 'cate_pid');
    }

//增加二级分类功能 此处有bug！！！
    public function getTree($data, $field_name, $field_id='id', $field_pid='pid', $pid='0'){
        $arr = array();
        foreach ($data as $k=>$v){
            if ($v->$field_pid == $pid){
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m=>$n){
                    if ($n->$field_pid == $v->$field_id){
                        $data[$m]["_".$field_name] = "*".$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;

    }
}
