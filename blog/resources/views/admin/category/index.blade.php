@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部分类
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分类管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分类</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        {{--<th class="tc" width="5%"><input type="checkbox" name=""></th>--}}
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>

                    {{--:Invalid argument supplied for foreach() 的中文意思是说foreach需要是一个数组而给它的是一个无效的参数.--}}
                    {{--循环前面加上判断,直接使用is_array判断给的值是不是为数组--}}
                    @foreach($data as $v)
                        <tr>
                            {{--<td class="tc"><input type="checkbox" name="id[]" value="59"></td>--}}
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this,{{$v->cate_id}} )" value="{{$v->cate_order}}">
                            </td>
                            <td class="tc">{{$v->cate_id}}</td>
                            <td>
                                <a href="#">{{$v->_cate_name}}</a>
                            </td>
                            <td>{{$v->cate_title}}</td>
                            <td>{{$v->cate_view}}</td>
                            {{--<td></td>--}}
                            <td>
                                <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                                <a href="javascript:" onclick="delCate({{$v->cate_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach

                </table>


{{--<div class="page_nav">--}}
{{--<div>--}}
{{--<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a> --}}
{{--<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a> --}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>--}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>--}}
{{--<span class="current">8</span>--}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>--}}
{{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a> --}}
{{--<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a> --}}
{{--<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a> --}}
{{--<span class="rows">11 条记录</span>--}}
{{--</div>--}}
{{--</div>--}}



                {{--<div class="page_list">--}}
                    {{--<ul>--}}
                        {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li><a href="#">&raquo;</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
            function changeOrder(obj, cate_id) {
                var cate_order = $(obj).val();
                $.post("{{url('admin/cate/changeorder')}}", {'_token':'{{csrf_token()}}', 'cate_id':cate_id, 'cate_order':cate_order }, function (data) {
                    if(data.status == 0){
                        layer.msg(data.msg, {icon: 6});
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            }
        //删除分类
        function delCate(cate_id) {
            layer.confirm('您确定要删除分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                //异步删除分类
                $.post("{{url('admin/category/')}}/"+cate_id,{'_method': 'delete','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status == 0){
                        window.location.reload(); //刷新当前页面
                        layer.msg(data.msg , {icon: 6})
                    }else{
                        layer.msg(data.msg , {icon: 5})
                    }
                })   //url ,参数， 回调函数
                // layer.msg('的确很重要', {icon: 1});
            }, function(){
            });
        }
    </script>
    
    
@endsection