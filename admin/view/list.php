<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>用户管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../../static/layui/css/layui.css" rel="stylesheet">
</head>

<body>
  <?php
  include dirname(dirname(__DIR__)) . '/mysql/sql.php';
  $userid = $_POST['userid'] ?? 0;
  $data = $_POST ?? [];
  $username = $data['username'] ?? '';
  $sex = $data['sex'] ?? '';
  $password = $data['password'] ?? '';
  $email = $data['email'] ?? '';
  $tel = $data['tel'] ?? '';
  // 加密
  if ($password != '') {
    $password = md5(md5($password));
  }
  // 查询编辑后的密码是否与加密后的密码一致，如果一致则返回1
  $user_pwd = sql("select password from users where userid = '$userid' and password='$password'", "recordCound");
  if ($user_pwd != 1) {
    $password = md5(md5($password));
  }
  // 添加表单
  $insert = $data['insert'] ?? null;
  // 编辑表单
  $update = $data['update'] ?? null;
  // 删除表单
  $delete = $data['delete'] ?? null;

  // 添加数据
  if ($username && $password && $email && $tel && $insert)
    sql("insert into users values(null,'$username','$sex','$email','$password','$tel',default)");
  // 删除数据
  if ($userid != 0 && $delete)
    sql("delete from users where userid = '$userid'");
  // 修改数据
  if ($username && $password && $email && $tel && $update)
    sql("update users set username='$username',sex='$sex',password='$password',email='$email',tel='$tel' where userid='$userid'");
  ?>
  <div class="form-h" style="display:none"></div>
  <div style="padding: 16px;">
    <table class="layui-hide" id="test" lay-filter="test"></table>
  </div>
  <script type="text/html" id="toolbarDemo">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
    <button class="layui-btn layui-btn-sm" lay-event="getData">获取当前页数据</button>
    <button class="layui-btn layui-btn-sm" id="dropdownButton">
      操作
      <i class="layui-icon layui-icon-down layui-font-12"></i>
    </button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" id="rowMode">
      <span>{{= d.lineStyle ? '多行' : '单行' }}模式</span>
      <i class="layui-icon layui-icon-down layui-font-12"></i>
    </button>
  </div>
</script>
  <script type="text/html" id="toolDemo">
  <div class="layui-clear-space">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs" lay-event="more">
      更多 
      <i class="layui-icon layui-icon-down"></i>
    </a>
  </div>
</script>
  <script src="../../static/layui/layui.js"></script>
  <script>
    layui.use(['table', 'dropdown'], function () {
      var table = layui.table;
      var dropdown = layui.dropdown;

      // 创建渲染实例
      table.render({
        elem: '#test',
        url: 'http://127.0.0.1/myblog/mysql/getUser.php', // 此处为静态模拟数据，实际使用时需换成真实接口
        toolbar: '#toolbarDemo',
        defaultToolbar: ['filter', 'exports', 'print', { // 右上角工具图标
          title: '提示',
          layEvent: 'LAYTABLE_TIPS',
          icon: 'layui-icon-tips',
          onClick: function (obj) { // 2.9.12+
            layer.alert('自定义工具栏图标按钮');
          }
        }],
        height: 'full-35', // 最大高度减去其他容器已占有的高度差
        css: [ // 重设当前表格样式
          '.layui-table-tool-temp{padding-right: 145px;}'
        ].join(''),
        cellMinWidth: 80,
        // totalRow: true, // 开启合计行
        // page: true,  // 分页
        cols: [[
          { type: 'checkbox', fixed: 'left' },
          { field: 'userid', fixed: 'left', width: 80, title: 'ID', sort: true, totalRow: '合计：' },
          { field: 'username', width: 109, title: '用户' },
          { field: 'email', width: 180, title: '邮箱' },
          { field: 'sex', width: 80, title: '性别', sort: true },
          { field: 'password', width: 300, title: '密码' },
          { field: 'tel', width: 120, title: '手机号', sort: true, totalRow: '{{= d.TOTAL_NUMS }} 😊' },
          { field: 'createtime', title: '注册时间', width: 180, sort: true, totalRow: '{{= parseInt(d.TOTAL_NUMS) }} 次' },
          { fixed: 'right', title: '操作', width: 134, minWidth: 125, templet: '#toolDemo' }
        ]],
        done: function () {
          var id = this.id;
          // 下拉按钮测试
          dropdown.render({
            elem: '#dropdownButton', // 可绑定在任意元素中，此处以上述按钮为例
            data: [{
              id: 'add',
              title: '添加'
            }, {
              id: 'update',
              title: '编辑'
            }, {
              id: 'delete',
              title: '删除'
            }],
            // 菜单被点击的事件
            click: function (obj) {
              var checkStatus = table.checkStatus(id)
              var data = checkStatus.data; // 获取选中的数据
              console.log(data);
              switch (obj.id) {
                case 'add':
                  layer.open({
                    title: '添加',
                    type: 1,
                    area: ['33%', '60%'],
                    content: `
           <div style="padding: 16px;>
            <div>
              <div class="layui-form">
                <form action="list.php" method="post" class="layui-form">
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">用户名</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="text" name="username" placeholder="请输入用户名" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">密码</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="password" name="password" placeholder="请输入密码" lay-verify="required"
                          autocomplete="off" class="layui-input" lay-affix="eye">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">邮箱</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="email" name="email" placeholder="请输入邮箱" lay-verify="required|email"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">手机号</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="tel" name="tel" placeholder="请输入手机号" lay-verify="required|phone"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">性别</label>
                          <input type="radio" name="sex" value="男" title="男" checked style="display:inline-block;margin:0.8em 0.2em 0 0">男
                          <input type="radio" name="sex" value="女" title="女" style="display:inline-block">女
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-btn-container">
                      <button type="submit" class="layui-btn" style="margin:1em 0 0 12em">提交</button>
                    </div>
                    <input type="hidden" name="insert" value="insert"/>
                  </div>
                </form>
              </div>
            <div>
          </div>`
                  });
                  break;
                case 'update':
                  if (data.length !== 1) return layer.msg('请选择一行');
                  layer.open({
                    title: '编辑',
                    type: 1,
                    area: ['33%', '60%'],
                    content: `
           <div style="padding: 16px;>
            <div>
              <div class="layui-form">
                <form action="list.php" method="post" class="layui-form">
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">用户名</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="text" name="username" value="${data[0].username}" placeholder="请输入用户名" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">密码</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="password" name="password" value="${data[0].password}" placeholder="请输入密码" lay-verify="required"
                          autocomplete="off" class="layui-input" lay-affix="eye">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">邮箱</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="email" value='${data[0].email}' name="email" placeholder="请输入邮箱" lay-verify="required|email"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">手机号</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="tel" value='${data[0].tel}' name="tel" placeholder="请输入手机号" lay-verify="required|phone"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">性别</label>
                          <input type="radio" name="sex" value="男" title="男" checked style="display:inline-block;margin:0.8em 0.2em 0 0">男
                          <input type="radio" name="sex" value="女" title="女" style="display:inline-block">女
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-btn-container">
                      <button type="submit" class="layui-btn" style="margin:1em 0 0 12em">提交</button>
                    </div>
                    <input type="hidden" name="update" value="update"/>
                    <input type="hidden" name="userid" value="${data[0].userid}">
                  </div>
                </form>
              </div>
            <div>
          </div>`
                  });
                  break;
                case 'delete':
                  if (data.length === 0) {
                    return layer.msg('请选择一行');
                  } layer.open({
                    title: '删除',
                    type: 1,
                    area: ['20%', '20%'],
                    content: `
                    <div style="padding: 16px;">
                      <div>
                        <div class="layui-form">
                          <form method='post' action='list.php'>
                          <h5 style="text-align: center;">确认删除么？</h5>
                            <input type='hidden' name="userid" value="${data[0].userid}">
                            <input type='hidden' name='delete' value='delete'">
                            <div class="layui-btn-container">
                              <button type="submit" class="layui-btn layui-btn-xs" style="margin:2em 0 0 7.5em">确认</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>`
                  });
                  // layer.msg('删除成功');
                  break;
              }
            }
          });

          // 行模式
          dropdown.render({
            elem: '#rowMode',
            data: [{
              id: 'default-row',
              title: '单行模式（默认）'
            }, {
              id: 'multi-row',
              title: '多行模式'
            }],
            // 菜单被点击的事件
            click: function (obj) {
              var checkStatus = table.checkStatus(id)
              var data = checkStatus.data; // 获取选中的数据
              switch (obj.id) {
                case 'default-row':
                  table.reload('test', {
                    lineStyle: null // 恢复单行
                  });
                  layer.msg('已设为单行');
                  break;
                case 'multi-row':
                  table.reload('test', {
                    // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
                    lineStyle: 'height: 95px;'  // 设置多行下的展示的高度
                  });
                  layer.msg('已设为多行');
                  break;
              }
            }
          });
        },
        error: function (res, msg) {
          console.log(res, msg)
        }
      });

      // 工具栏事件
      table.on('toolbar(test)', function (obj) {
        var id = obj.config.id;
        var checkStatus = table.checkStatus(id);
        var othis = lay(this);
        switch (obj.event) {
          case 'getCheckData':
            var data = checkStatus.data;
            layer.alert(layui.util.escape(JSON.stringify(data)));
            break;
          case 'getData':
            var getData = table.getData(id);
            console.log(getData);
            layer.alert(layui.util.escape(JSON.stringify(getData)));
            break;
        };
      });
      // 表头自定义元素工具事件 --- 2.8.8+
      table.on('colTool(test)', function (obj) {
        var event = obj.event;
        console.log(obj);
        if (event === 'email-tips') {
          layer.alert(layui.util.escape(JSON.stringify(obj.col)), {
            title: '当前列属性配置项'
          });
        }
      });

      // 触发单元格工具事件
      table.on('tool(test)', function (obj) { // 双击 toolDouble
        console.log(obj.data.userid); // 获取用户id
        var data = obj.data; // 获得当前行数据
        if (obj.event === 'edit') {
          layer.open({
            title: '编辑 - id:' + data.userid,
            type: 1,
            area: ['33%', '60%'],
            content: `
           <div style="padding: 16px;>
            <div>
              <div class="layui-form">
                <form action="list.php" method="post" class="layui-form">
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">用户名</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="text" name="username" value="${data.username}" placeholder="请输入用户名" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">密码</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="password" name="password" value="${data.password} placeholder="请输入密码" lay-verify="required"
                          autocomplete="off" class="layui-input" lay-affix="eye">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">邮箱</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="email" value='${data.email}' name="email" placeholder="请输入邮箱" lay-verify="required|email"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">手机号</label>
                      <div class="layui-input-inline" style="width: 220px;">
                        <input type="tel" value='${data.tel}' name="tel" placeholder="请输入手机号" lay-verify="required|phone"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-form-item">
                      <label class="layui-form-label">性别</label>
                          <input type="radio" name="sex" value="男" title="男" checked style="display:inline-block;margin:0.8em 0.2em 0 0">男
                          <input type="radio" name="sex" value="女" title="女" style="display:inline-block">女
                    </div>
                  </div>
                  <div class="items">
                    <div class="layui-btn-container">
                      <button type="submit" class="layui-btn" style="margin:2em 0 0 12em">提交</button>
                    </div>
                    <input type="hidden" name="update" value="update"/>
                    <input type="hidden" name="userid" value="${data.userid}">
                  </div>
                </form>
              </div>
            <div>
          </div>`
          });
        } else if (obj.event === 'more') {
          // 更多 - 下拉菜单
          dropdown.render({
            elem: this, // 触发事件的 DOM 对象
            show: true, // 外部事件触发即显示
            data: [{
              title: '查看',
              id: 'detail'
            }, {
              title: '删除',
              id: 'del'
            }],
            click: function (menudata) {
              if (menudata.id === 'detail') {
                layer.msg('查看操作，当前行 ID:' + data.userid);
              } else if (menudata.id === 'del') {
                layer.confirm('真的删除行 [id: ' + data.userid + '] 么', function (index) {
                  obj.del(); // 删除对应行（tr）的DOM结构
                  layer.close(index);
                  // 插入隐藏域向服务器提交数据
                  document.querySelector('.form-h').innerHTML = `
                  <form method='post' action='list.php'>
                    <input type='hidden' name="userid" value="${data.userid}">
                    <input type='hidden' name="delete" value="delete">
                    <button type='submit' class='btn-h'></button>
                  </form>
                  `;
                  document.querySelector('form').submit();
                });
              }
            },
            id: 'dropdown-table-tool',
            align: 'right', // 右对齐弹出
            style: 'box-shadow: 1px 1px 10px rgb(0 0 0 / 12%);' // 设置额外样式
          });
        }
      });
      // table 滚动时移除内部弹出的元素
      var tableInst = table.getOptions('test');
      tableInst.elem.next().find('.layui-table-main').on('scroll', function () {
        dropdown.close('dropdown-table-tool');
      });

      // 触发表格复选框选择
      table.on('checkbox(test)', function (obj) {
        console.log(obj)
      });

      // 触发表格单选框选择
      table.on('radio(test)', function (obj) {
        console.log(obj)
      });

      // 行单击事件
      table.on('row(test)', function (obj) {
        //console.log(obj);
        //layer.closeAll('tips');
      });
      // 行双击事件
      table.on('rowDouble(test)', function (obj) {
        console.log(obj.data.userid);
      });
    });
  </script>
</body>
</html>