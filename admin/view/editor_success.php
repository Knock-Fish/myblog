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
        <h1>发表成功√</h1>
        <p>等待3秒后跳转……</p>
    </div>
    <?php
        include dirname(dirname(__DIR__)) . '/mysql/sql.php';
        sql("insert into articles values(
        null,
        null,
        '{$_POST['admin_id']}',
        '{$_POST['title']}',
        '{$_POST['editormd-markdown-doc']}',
        0,
        default
        );");
        $article_id =  sql("select article_id from articles where article_content='{$_POST['editormd-markdown-doc']}';","data")[0];
        sql("insert into articles_classify values({$article_id['article_id']},{$_POST['admin_id']});");
        header('refresh:3;url=./articles.php');
    ?>
</body>
</html>