<!DOCTYPE html>
<lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="../static/layui/css/layui.css">
		<link rel="stylesheet" type="text/css" href="../static/css/login.css">
		<title>博客登录</title>
	</head>
	<?php
	include dirname(__DIR__) . '/mysql/sql.php';
	$data = $_POST ?? NULL;
	$username = $data['username'] ?? '';
	$password = $data['password'] ?? '';
	if ($password != '') {
		$password = md5(md5($data['password']));
	}
	?>
	
	<body>
		<div class="nav">
		<ul class="layui-nav layui-bg-cyan">
			<li class="layui-nav-item"><a href="index.html">博客</a></li>
			<li class="layui-nav-item"><a href="https:www.baidu.com">百度</a></li>
		</ul>
	</div>
		<div class="login-body">
			<div class="layui-form">
				<form action="login.php" method="post">
					<div class="login" style="margin:120px 120px">
						<header class="title">
							博客登录
						</header>
						<div class="demo-login-container">
							<div class="login-container">
								<div class="layui-form-item">
									<div class="layui-input-wrap">
										<div class="layui-input-prefix">
											<i class="layui-icon layui-icon-username"></i>
										</div>
										<input type="text" name="username" value="" lay-verify="required"
											placeholder="用户名" lay-reqtext="请填写用户名" autocomplete="off"
											class="layui-input" lay-affix="clear">
									</div>
								</div>
								<div class="layui-form-item">
									<div class="layui-input-wrap">
										<div class="layui-input-prefix">
											<i class="layui-icon layui-icon-password"></i>
										</div>
										<input type="password" name="password" value="" lay-verify="required"
											placeholder="密   码" lay-reqtext="请填写密码" autocomplete="off"
											class="layui-input" lay-affix="eye">
									</div>
								</div>
							</div>
							<?php
							$user = sql("select * from users where username='$username' and password='$password'", "recordCount");
							if ($user == 0 && $username != '' && $password != '') {
								echo "<span style='margin-left:25px;color:red;''>用户名或密码错误</span>";
							}
							?>
							<a href="#" class="forget_pwd">
								忘记密码？
							</a>
							<br>
							<div class="btn_login">
								<button type="submit" class="layui-btn layui-btn-fluid">登录</button>
							</div>
							<span class="register">
								还没有博客账号？
								<a href="../view/register.php">
									立即注册
								</a>
							</span>
							<span class="three">
								第三方账号登录
							</span>
						</div>
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
		if ($user == 1) {
			$userid = sql("select * from users where username='$username' and password='$password'", "data");
			// 存储临时会话
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['userid'] = $userid[0]['userid'];
			echo "<script>location.href = '../index.php';</script>";
		}
		?>
	</body>

	</html>