<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>博客首页</title>
  <link rel="stylesheet" href="./static/layui/css/layui.css">
  <link rel="stylesheet" href="./static/css/index.css">
</head>
<?php
include dirname(__DIR__) . '/myblog/mysql/sql.php';
session_start();
$username = $_SESSION['username'] ?? '';
$userid = $_SESSION['userid'] ?? '';
$user_data = sql("select * from users where username='$username'", "data")[0] ?? [];
$article_array = sql("select * from articles;", "data");
?>

<body>
  <!-- 顶部导航栏 -->
  <div class="nav">
    <ul class="layui-nav layui-bg-cyan">
      <li class="layui-nav-item"><a href="index.html">博客</a></li>
      <li class="layui-nav-item"><a href="https:www.baidu.com">百度</a></li>
      <li class="layui-nav-item">
        <a href=<?php
        if ($username == '') {
          echo "./view/login.php";
        } else {
          echo "./view/blog_editor.php?id={$user_data['userid']}";
        }
        ?>>发表</a>
      </li>
      <li class="layui-nav-item">
        <?php
        if ($username == '') {
          echo "
          <a href='javascript:;'>我的</a>
          <dl class='layui-nav-child'>
            <dd><a href='./view/login.php'>收藏</a></dd>
            <dd><a href='./view/login.php'>文章</a></dd>
            <dd><a href='./view/login.php'>个人中心</a></dd>
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
  <div class="layui-container">
    <div class="layui-row">
      <div class="layui-col-xs9">
<?php
foreach ($article_array as $article) {
    if ($article['userid'] != '') {
      $author = sql("select username from users where userid='{$article['userid']}'","data")[0];
      echo " 
      <div class='container-left'>
      <a href='./view/containerView.php?id={$article['article_id']}&role=1'>
      <h2>{$article['article_title']}</h2>
      <div class='container'>
        {$article['article_content']}
    </div>
      <div class='author_views'>
        <span class='author'>作者：{$author['username']}</span>
        ";
    } else {
      $author = sql("select admin_name from admin where admin_id='{$article['admin_id']}'","data")[0];
      echo "
      <div class='container-left'>
      <a href='./view/containerView.php?id={$article['article_id']}&&role=2'>
      <h2>{$article['article_title']}</h2>
      <div class='container'>
        {$article['article_content']}
    </div> 
    <div class='author_views'>
      <span class='author'>作者：{$author['admin_name']}</span>
      ";
    }
    echo "<span class='views'>浏览量：{$article['article_views']}</span>
    </div>
    </a>
  </div>";
  }
?>
      </div>
      <div class="layui-col-xs3">
        <div class="container-right">
          <span class="about-my">关于我</span>
          <div class="avatar">
            <!-- 头像 -->
          </div>
          <p class="username">
            <?= $user_data['username'] ?? "<a href='./view/login.php' style='color:red'>您好，请先登录</a>"; ?>
          </p>
          <p class="email">email: <?= $user_data['email'] ?? '请先登录'; ?></p>
          <div id="text">
            这个人什么都不说~
          </div>
        </div>
        <div class="container-right-classify">
          <h2>分类</h2>
          <ul>
            <?php
              $classify_data = sql("select * from classify;","data");
              foreach($classify_data as $value){
                $classify_num = sql(
                  "select * 
                  from articles_classify 
                  join classify 
                  on articles_classify.classify_id = classify.classify_id
                  where articles_classify.classify_id = '{$value['classify_id']}';","recordCount");
                  echo "
                    <li class='classify-items'>
                      <span class='prog'>{$value['classify_name']}</span>
                      <span class='prog_num'>[ {$classify_num} ]</span>
                    </li>
                  ";
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="./static/layui/layui.js"></script>
</body>

</html>