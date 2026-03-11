<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>博客注册</title>
	<link rel="stylesheet" type="text/css" href="../static/layui/css/layui.css">
	<link rel="stylesheet" type="text/css" href="../static/css/register.css">
</head>
<?php
	include dirname(__DIR__).'/mysql/sql.php';
	$data = $_POST ?? null;
	$username = $data['username'] ?? '';
	$password = $data['password'] ?? '';
	$password_confirm = $data['password_confirm'] ?? '';
	$email = $data['email'] ?? '';
	$tel = $data['tel'] ?? '';
	$sex = $data['sex'] ?? '';
?>
<body>
	<div class="register">
		<div class="title">
			<h2>欢迎注册博客</h2>
		</div>
		<div class="layui-form">
			<form action="register.php" method="post" class="layui-form">
				<div class="items">
					<div class="layui-form-item">
						<label class="layui-form-label">用户名</label>
						<div class="layui-input-inline" style="width: 220px;">
							<input type="text" name="username" placeholder="请输入用户名" lay-verify="required"
								autocomplete="off" class="layui-input">
						</div>
						<?php
						$ut_value = sql("select * from users where username='$username'","recordCount");
						if($ut_value>0){
							echo "<div class='layui-form-mid danger'>用户名已存在！</div>";
						}elseif($ut_value==0){
							echo "<div class='layui-form-mid layui-text-em'>请务必填写用户名</div>";
						}
						?>
					</div>
				</div>
				<div class="items">
					<div class="layui-form-item">
						<label class="layui-form-label">密码</label>
						<div class="layui-input-inline" style="width: 220px;">
							<input type="password" name="password" placeholder="请输入密码" lay-verify="required"
								autocomplete="off" class="layui-input" lay-affix="eye">
						</div>
						<div class="layui-form-mid layui-text-em">请务必填写密码</div>
					</div>
				</div>
				<div class="items">
					<div class="layui-form-item">
						<label class="layui-form-label">确认密码</label>
						<div class="layui-input-inline" style="width: 220px;">
							<input type="password" name="password_confirm" placeholder="请输入密码" lay-verify="required"
								autocomplete="off" class="layui-input" lay-affix="eye">
						</div>
						<?php
							if($password == $password_confirm){
								echo "<div class='layui-form-mid layui-text-em'>请再输入密码</div>";
							}elseif($password != $password_confirm){
								echo "<div class='layui-form-mid danger'>密码不一致！</div>";
							}
						?>
					</div>
				</div>
				<div class="items">
					<div class="layui-form-item">
						<label class="layui-form-label">邮箱</label>
						<div class="layui-input-inline" style="width: 220px;">
							<input type="email" name="email" placeholder="请输入邮箱" lay-verify="required|email"
								autocomplete="off" class="layui-input">
						</div>
						<?php
						$et_value = sql("select * from users where username='$email'","recordCount");
						if($et_value>0){
							echo "<div class='layui-form-mid danger'>邮箱已被注册</div>";
						}elseif($et_value==0){
							echo "<div class='layui-form-mid layui-text-em'>请务必填写邮箱</div>";
						}
						?>
					</div>
				</div>
				<div class="items">
					<div class="layui-form-item">
						<label class="layui-form-label">手机号</label>
						<div class="layui-input-inline" style="width: 220px;">
							<input type="tel" name="tel" placeholder="请输入手机号" lay-verify="required|phone"
								autocomplete="off" class="layui-input">
						</div>
						<?php
						$tt_value = sql("select * from users where username='$tel'","recordCount");
						if($tt_value>0){
							echo "<div class='layui-form-mid danger'>手机号已被注册</div>";
						}elseif($tt_value==0){
							echo "<div class='layui-form-mid layui-text-em'>请务必填写手机号</div>";
						}
						?>
					</div>
				</div>
				<div class="items">
					<div class="layui-form-item layui-margin-2">
						<label class="layui-form-label">性别</label>
						<div class="layui-input-inline">
							<input type="radio" name="sex" value="男" title="男" checked>
							<input type="radio" name="sex" value="女" title="女">
						</div>
					</div>
				</div>
				<input type="hidden" value="register" name="register">
				<span class="login">已有账号？<a href="./login.php">登录</a></span>
				<div class="layui-btn-container btn">
					<button type="submit" class="layui-btn layui-btn-lg layui-btn-fluid">注册</button>
					<button type="reset" class="layui-btn layui-btn-lg layui-bg-red layui-btn-fluid">重置</button>
				</div>
				<div class="agreement">
					<input type="checkbox" name="agreement" id="agreement" title="同意并遵守博客"><a href="#">《用户使用协议》</a>
				</div>
			</form>
		</div>
	</div>
	<footer>
		<div class="foot">
			<a href="#">
				关于博客
			</a>
			|
			<a href="#">
				服务条款
			</a>
			|
			<a href="#">
				客服中心
			</a>
			</a>
			|
			<a href="#">
				联系我们
			</a>
			|
			<a href="#">
				帮助中心
			</a>
			|
			<a href="../意见反馈/suggestion.html">
				意见反馈
			</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&copy;1995-2017&nbsp;&nbsp;F&nbsp;&nbsp;Inc.&nbsp;&nbsp;All&nbsp;&nbsp;Rights&nbsp;&nbsp;Reserved.
		</div>
	</footer>
	<script src="../static/layui/layui.js"></script>
	<?php
		if(($ut_value == $et_value) == ($tt_value == 0) && $password != '' && $password==$password_confirm){
			$password = md5(md5($password));
			sql("insert into users values(null,'$username','$sex','$email','$password','$tel',default)");
			echo "<script>location.href = '../view/login.php';</script>";
			exit;
			}
	?>
</body>

</html>