<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	{{--asset()引用静态文件css，js等，文件需要在public目录下--}}
	<link rel="stylesheet" href="{{asset('css/ch-ui.admin.css')}}"/>
	<link rel="stylesheet" href="{{asset('css/font/css/font-awesome.min.css')}}"/>
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">
			@if(session('msg'))
			<p style="color:red">{{session('msg')}}</p>
			@endif
			<form action="" method="post">
				{{csrf_field()}}
				<ul>
					<li>
					<input type="text" name="user_name" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="user_pass" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						{{--获取验证码--}}
						<img src="{{url('admin/code')}}" alt="" onclick="this.src='{{url('admin/code')}}?'+Math.random()">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2018 Powered by <a href="http://www.houdunwang.com" target="_blank">HK</a></p>
		</div>
	</div>
</body>
</html>