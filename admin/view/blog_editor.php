<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>博客编辑页</title>
    <link rel="stylesheet" href="../../static/css/blog_editor.css">
    <!-- 引入依赖 -->
    <link rel="stylesheet" href="../../static/layui/css/layui.css">
    <link rel="stylesheet" href="../../static/editor.md-master/css/editormd.min.css">
    <script src="../../static/js/jquery-min.js"></script>
    <script src="../../static/editor.md-master/lib/marked.min.js"></script>
    <script src="../../static/editor.md-master/lib/prettify.min.js"></script>
    <script src="../../static/editor.md-master/editormd.js"></script>
</head>
<?php
include dirname(dirname(__DIR__)) . '/mysql/sql.php';
$classify_array = sql("select * from classify order by classify_id;","data");
$admin_array = sql("select * from admin","data");
session_start();
$admin_name = $_SESSION['admin_name'];
$admin_id = $_SESSION['admin_id'];
?>
<body>
    <div class="layui-container">
        <div class="layui-form">
            <form action="editor_success.php" class="layui-form" method="post">
                <div class="container">
                    <div class="layui-form-item">
                        <label class="layui-form-label" style="padding:3em 1em">文章标题</label>
                        <div class="layui-input-inline" style="width:35%;padding:2.4em 0;">
                            <input type="text" name="title" lay-verify="required" placeholder="请输入标题"
                                autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-input-inline" style="padding:2.4em 0;">
                            <select name="classify" lay-verify="required" lay-search>
                                <option value="">请选择分类</option>
                                <?php
                                    foreach($classify_array as $classify){
                                        echo "<option value='{$classify['classify_id']}'>{$classify['classify_name']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="admin_id" value="<?=$admin_id?>">
                        <div class="layui-input-inline" style="float:right;width:100px;margin:2.5em 5em 0 0">
                            <button type="submit" class="layui-btn layui-bg-blue" style="width:100px">发表</button>
                        </div>
                    </div>
                </div>
                <!-- 内容编辑区 -->
                <div id="editormd">
                    <textarea class="editormd-markdown-textarea" name="editormd-markdown-doc"></textarea>
                </div>
            </form>
        </div>
    </div>
    <script src="../../static/layui/layui.js"></script>
    <script>
        // 初始化 editor.md
        let editor = editormd("editormd", {
            // 这里的尺寸必须在这里设置，设置样式会被 editormd 自动覆盖
            width: "100%",
            // 设定编辑高度
            height: "590px",
            // 编辑页中的初始化内容
            markdown: "## 在这里写下一篇博客",
            //指定 editor.md 依赖的插件路径
            path: "../../static/editor.md-master/lib/",
            saveHTMLToTextatea: true,
        });
    </script>
</body>

</html>