<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登入 - 博客后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="../layuiadmin/style/login.css" media="all">
</head>
<?php
include dirname(dirname(__DIR__)) . '/mysql/sql.php';
$data = sql("select * from admin;","data");
$admin_name = $_POST['admin_name'] ?? '';
$admin_password = $_POST['admin_password'] ?? '';
$admin = sql("select * from admin where admin_name='$admin_name' and admin_password='$admin_password';","recordCount");
if ($admin == 1) {
    $admin_id = sql("select admin_id from admin where admin_name='$admin_name' and admin_password='$admin_password';", "data");
    // 存储临时会话
    session_start();
    $_SESSION['admin_name'] = $admin_name;
    $_SESSION['admin_id'] = $admin_id[0]['admin_id'];
    echo "<script>location.href = '../index.php';</script>";
}
?>
<body>
    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
        <div class="layadmin-user-login-main">
            <div class="layadmin-user-login-box layadmin-user-login-header">
                <h2>MyBlog</h2>
                <p>博客后台管理系统</p>
            </div>
            <form action="#" method="post">
                <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-username"
                            for="LAY-user-login-username"></label>
                        <input type="text" name="admin_name" id="LAY-user-login-username" lay-verify="required"
                            placeholder="用户名" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password"
                            for="LAY-user-login-password"></label>
                        <input type="password" name="admin_password" id="LAY-user-login-password" lay-verify="required"
                            placeholder="密码" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <button type="submit" class="layui-btn layui-btn-fluid" lay-submit
                            lay-filter="LAY-user-login-submit">登
                            入</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="layui-trans layadmin-user-login-footer">

            <p>© 2018 <a href="#" target="_blank">www.myblog.com</a></p>
            <p>
                <span><a href="#" target="_blank">前往博客</a></span>
            </p>
        </div>
    </div>
    <script src="../layuiadmin/layui/layui.js"></script>
</body>

</html>