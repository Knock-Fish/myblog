<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>博文</title>
    <link rel="stylesheet" href="../static/layui/css/layui.css">
    <link rel="stylesheet" href="../static/css/containerView.css">
    <link rel="stylesheet" href="../static/editor.md-master/css/editormd.css">
    <script type="text/javascript" src="../static/js/jquery-min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/flowchart.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/jquery.flowchart.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/marked.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/prettify.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/raphael.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/underscore.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/lib/sequence-diagram.min.js"></script>
    <script type="text/javascript" src="../static/editor.md-master/editormd.js"></script>
</head>
<?php
include dirname(__DIR__) . '/mysql/sql.php';
session_start();
$userid = $_SESSION['userid'] ?? '';
// 截取url查询字符串的参数
$query_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$query_str = parse_url($query_url);
preg_match_all('/\d+/', $query_str['query'], $url_str);
if($url_str[0][1] == 1){
    $article_data = sql("
    select article_id,articles.userid,article_title,article_content,article_views,article_date,username 
    from articles 
    join users 
    on articles.userid=users.userid 
    where articles.article_id={$url_str[0][0]};", "data")[0];
}elseif($url_str[0][1] == 2){
    $article_data = sql("
    select article_id,articles.userid,article_title,article_content,article_views,article_date,admin_name
    from articles 
    join admin
    on articles.admin_id=admin.admin_id 
    where articles.article_id={$url_str[0][0]};", "data")[0];
}
// 获取文章分类
$article_classify = sql("
select classify_name
from classify 
join articles_classify 
on classify.classify_id = articles_classify.classify_id 
where article_id = {$article_data['article_id']};", "data")[0];



?>

<body>
    <!-- 顶部导航栏 -->
    <div class="nav">
        <ul class="layui-nav layui-bg-cyan">
            <li class="layui-nav-item"><a href="../index.php">博客</a></li>
            <li class="layui-nav-item"><a href="https:www.baidu.com">百度</a></li>
            <li class="layui-nav-item">
                <a href=<?php
                if ($userid == '') {
                    echo "./login.php";
                } else {
                    echo "./blog_editor.php?id=$userid";
                }
                ?>>发表</a>
            </li>
            <li class="layui-nav-item">
                <?php
                if ($userid == '') {
                    echo "
          <a href='javascript:;'>我的</a>
          <dl class='layui-nav-child'>
            <dd><a href='./login.php'>收藏</a></dd>
            <dd><a href='./login.php'>文章</a></dd>
            <dd><a href='./login.php'>个人中心</a></dd>
          </dl>";
                } else {
                    echo "
          <a href='javascript:;'>我的</a>
          <dl class='layui-nav-child'>
            <dd><a href=''>收藏</a></dd>
            <dd><a href=''>文章</a></dd>
            <dd><a href=''>个人中心</a></dd>
          </dl>";
                }
                ?>
            </li>
            <li class="nav-seach">
                <form action="#" class="layui-form">
                    <div class="layui-input-group">
                        <input type="text" placeholder="请输入关键词" class="layui-input">
                        <div class="layui-input-suffix">
                            <button class="layui-btn">搜索</button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    </div>
    <div class="container">
        <div class="title">
            <?= $article_data['article_title'] ?>
        </div>
        <div class="username-view">
            <p class="author">
                <span>作者： <?php 
                if($url_str[0][1] == 1){echo $article_data['username'];} 
                elseif($url_str[0][1] == 2){echo $article_data['admin_name'];}
                ?></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>发表日期： <?= $article_data['article_date'] ?></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>浏览量：<?= $article_data['article_views'] ?></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>分类专栏：<span class="column"><?= $article_classify['classify_name'] ?></span></span>
            </p>
        </div>
        <div id="container-text" style="width:1200px;box-sizing: border-box;margin:auto;">
            <textarea id="appendTest" style="display:none;width:100px">
                            <?= $article_data['article_content'] ?>
                    </textarea>
        </div>
    </div>

    <script src="../static/layui/layui.js"></script>
    <script type="text/javascript">
        $(function () {
            editormd.markdownToHTML('container-text', {
                htmlDecode: "style,script,iframe",  // 过滤标签解码
                emoji: true,
                taskList: true,
                tex: true,
                flowChart: true,
                sequenceDiagram: true,
            })
        })

    </script>
</body>

</html>