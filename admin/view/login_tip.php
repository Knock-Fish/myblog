<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>页面跳转</title>
</head>
<style>
    body{
        background-color: rgb(240, 240, 240);
    }
    div{
        box-sizing: border-box;
        background-color: #fff;
        width: 400px;
        height: 250px;
        margin: auto;
        padding-top: 50px;
        text-align: center;
        transform: translateY(100%);
    }
</style>
<body>
    <div>
        <h1>请先登录</h1>
        <p>等待1秒后跳转……</p>
    </div>
    <?php
        header('refresh:1;url=./login.php');
    ?>
</body>
</html>