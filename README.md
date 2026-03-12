## 个人博客开发的技术栈与框架

1、PHP编程语言：PHP是一种广泛使用的服务器端脚本语言，特别适合Web开发。在博客系统中，PHP负责处理服务器端逻辑和动态渲染页面，如用户注册与登录、文章发布与管理等功能。

2、Layui组件库：Layui是一套免费的开源Web UI组件库，采用自身轻量级模块化规范，遵循原生态的HTML/CSS/JavaScript开发模式。Layui组件库用于美化前端页面，可以在HTML中轻松使用这些组件来构建博客的界面。

3、Editor.md在线编辑器：Editor.md是一个基于Markdown语法的编辑器插件，支持实时预览、代码插入、代码折叠、列表插入等功能。Editor.md作为Markdown编辑器，使得文章内容的编写和排版变得更加简单和直观。用户可以通过Markdown语法编写文章，并实时预览效果，提高写作效率。

4、jQuery库：jQuery是一个快速、小巧、功能丰富的JavaScript库。简化了HTML文档遍历与操作、事件处理、动画等以实现快速的Web开发。jQuery用于实现前端页面的交互功能。

5、MySQL数据库：数据库是存储数据的工具，它可以存储各种类型的数据，包括文本、图像、音频和视频等。可以使用MySQL等关系型数据库管理系统来设计博客系统的数据库。例如，可以创建用户表来存储用户信息（如用户名、密码、邮箱等），创建文章表来存储文章信息（如文章标题、内容、发布时间等）

## 界面设计

界面设计采用Layui组件库快速搭建页面，主要包括以下页面：

1、首页侧边栏展示用户登录信息，内容展示预览文章

![](https://github.com/Knock-Fish/myblog/blob/main/images/2.png?raw=true)

![](https://github.com/Knock-Fish/myblog/blob/main/images/4.png?raw=true)

2、登录页面：用户输入用户名和密码进行登录。验证用户名和密码，登录成功跳转到相应页面

![](https://github.com/Knock-Fish/myblog/blob/main/images/3.png?raw=true)

3、注册页面：收集用户的用户名、密码、邮箱、手机号、性别注册信息。验证用户输入的格式，注册成功跳转到登录页面

![](https://github.com/Knock-Fish/myblog/blob/main/images/1.png?raw=true)

4、文章页面：展示文章内容，包括文章标题、内容、作者、发表日期和浏览量

![](https://github.com/Knock-Fish/myblog/blob/main/images/8.png?raw=true)

5、发表页面：展示用户发表文章的功能。嵌入Markdown编辑器提供文章编辑、发布等功能

![](https://github.com/Knock-Fish/myblog/blob/main/images/5.png?raw=true)

6、后台登录：只有是管理员的账号才可以登录

![](https://github.com/Knock-Fish/myblog/blob/main/images/9.png?raw=true)

7、用户管理：展示用户的注册信息和管理操作

![](https://github.com/Knock-Fish/myblog/blob/main/images/10.png?raw=true)

![](https://github.com/Knock-Fish/myblog/blob/main/images/12.png?raw=true)

8、管理员列表：展示管理员的信息和管理操作

![](https://github.com/Knock-Fish/myblog/blob/main/images/13.png?raw=true)

9、文章管理：展示用户和管理员的文章和管理操作

![](https://github.com/Knock-Fish/myblog/blob/main/images/14.png?raw=true)

![](https://github.com/Knock-Fish/myblog/blob/main/images/16.png?raw=true)

10、分类管理：展示文章的分类和管理操作

![](https://github.com/Knock-Fish/myblog/blob/main/images/15.png?raw=true)
