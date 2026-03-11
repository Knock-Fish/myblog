/*
 Navicat MySQL Data Transfer

 Source Server         : php
 Source Server Type    : MySQL
 Source Server Version : 80031
 Source Host           : localhost:3308
 Source Schema         : myblog

 Target Server Type    : MySQL
 Target Server Version : 80031
 File Encoding         : 65001

 Date: 21/12/2024 21:23:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `admin_id` bigint NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `admin_password` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`admin_id`) USING BTREE,
  UNIQUE INDEX `admin_name`(`admin_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, '超级管理员', '123456');

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles`  (
  `article_id` bigint NOT NULL AUTO_INCREMENT,
  `userid` bigint NULL DEFAULT NULL,
  `admin_id` bigint NULL DEFAULT NULL,
  `article_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `article_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `article_views` bigint NOT NULL,
  `article_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`article_id`) USING BTREE,
  INDEX `articles_ib_fk_1`(`userid`) USING BTREE,
  INDEX `articles_ib_fk_2`(`admin_id`) USING BTREE,
  CONSTRAINT `articles_ib_fk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `articles_ib_fk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES (1, 1, NULL, 'Java对象和类', '## 类（Class）\r\n\r\n定义对象的蓝图（包括属性和方法），描述一类对象的行为和状态\r\n\r\n使用`class`定义类：\r\n\r\n```java\r\n/* \r\n    [修饰符] class 类名{\r\n        属性声明;\r\n        方法声明;\r\n    }\r\n*/\r\n\r\npublic class Persons{\r\n    // 声明属性name\r\n    String name;\r\n    \r\n    // 声明方法\r\n    public void say(){\r\n        System.out.println(\"你好\");\r\n    }\r\n}\r\n```\r\n\r\n一个类可以拥有多个方法\r\n\r\n一个类可以包含以下类型变量：\r\n\r\n- **局部变量**：在方法、构造方法或者语句块中定义的变量被称为局部变量。变量声明和初始化都是在方法中，方法结束后，变量就会自动销毁\r\n- **成员变量**：成员变量是定义在类中，方法体之外的变量。这种变量在创建对象的时候实例化。成员变量可以被类中方法、构造方法和特定类的语句块访问\r\n- **类变量**：类变量也声明在类中，方法体之外，但必须声明为 `static` 类型\r\n\r\n\r\n\r\n## 对象（Object）\r\n\r\n类的实例，具有状态和行为\r\n\r\n### 对象的创建和调用\r\n\r\n对象是根据类创建的。使用关键字 `new` 来创建一个新的对象。创建对象需要以下三步：\r\n\r\n- **声明**：声明一个对象，包括对象名称和对象类型\r\n- **实例化**：使用关键字 new 来创建一个对象\r\n- **初始化**：使用 new 创建对象时，会调用构造方法初始化对象\r\n\r\n```java\r\n/*\r\n    实例化对象\r\n    方式1：给创建的对象命名\r\n    类名 对象名 = new 类名();\r\n\r\n    方式2：匿名\r\n    new 类名();\r\n*/\r\n\r\npublic class Persons{\r\n    String name;\r\n        int age;\r\n    public void say(){\r\n        System.out.println(\"你好\");\r\n    }\r\n}\r\nclass Person{\r\n    public static void main(String[] args){\r\n        // 创建 Person 类的对象\r\n        Persons p1 = new Persons();\r\n        // 访问属性\r\n        p1.age = 18;\r\n        p1.name = \"张三\";\r\n        // 访问方法\r\n        p1.say();\r\n    }\r\n}\r\n```\r\n\r\n### 匿名对象（anonymous object）\r\n\r\n匿名对象：可以不定义对象的句柄，直接调用这个对象的方法\r\n\r\n- 如果一个对象只需要进行一次方法调用，那么就可以使用匿名对象\r\n- 常用将匿名对象作为实参传递给一个方法调用\r\n\r\n```java\r\npublic class Persons{\r\n    String name;\r\n        int age;\r\n    public void say(){\r\n        System.out.println(\"你好\");\r\n    }\r\n}\r\nclass Person{\r\n    public static void main(String[] args){\r\n       new Persons().say();		// 匿名对象\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n## 构造器（构造方法）\r\n\r\n在 `new` 对象的时候为实例变量赋值\r\n\r\n- 构造器名必须与它所在的类名相同\r\n- 没有返回值，不需要返回值类型，也不需要 `void`\r\n- 构造器的修饰符只能时权限修饰符，不能被其他任何修饰\r\n- 不能有 `return` 语句返回值\r\n- 如没有显式的声明类中的构造器时，会默认提供一个无参构造器并且修饰符默认与类的修饰符相同（在类中至少存在一个构造器）\r\n- 构造器是可以重载的\r\n\r\n```java\r\n/*	构造器的语法格式\r\n[修饰符] class 类名{\r\n    [修饰符] 构造器(){\r\n        实例初始化代码\r\n    }\r\n    [修饰符] 构造器(参数列表){\r\n        实例初始化代码\r\n    }\r\n}\r\n*/\r\n\r\nclass Constructor{\r\n    private int a;\r\n    private int b;\r\n    Constructor(){}     // 无参构造器\r\n    Constructor(int a, int b){    // 有参构造器\r\n        this.a = a;\r\n        this.b = b;\r\n    }\r\n    public int add(){\r\n        return a + b;\r\n    }\r\n}\r\n\r\npublic class Test{\r\n    public static void main(String[] args) {\r\n        // 调用无参构造器创建对象\r\n        Constructor obj1 = new Constructor();\r\n        System.out.println(obj1.add());     // 0\r\n\r\n        // 调用有参构造创建对象\r\n        Constructor obj2 = new Constructor(1, 2);\r\n        System.out.println(obj2.add());     // 3\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n## this\r\n\r\n`this` 可以调用的结构：成员变量、方法和构造器\r\n\r\n### this访问对象的成员\r\n\r\n在实例方法或构造器中，如果使用当前类的成员变量或成员方法可以在其前面添加 `this`\r\n\r\n当形参与成员变量同名时，如果在方法内或构造器内需要使用成员变量，必须添加 `this` 来表明该变量是类的成员变量\r\n\r\n```java\r\n// 可以用 this 来区分 成员变量 和 局部变量\r\npublic class Person{\r\n    String name;\r\n    public void setName(String name){\r\n        // 成员变量 = 局部变量\r\n        this.name = name;\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n使用 `this` 访问属性和方法时，如果在本类中未找到，会从父类中查找\r\n\r\n```java\r\nclass Father {\r\n    Father(){\r\n        System.out.println(\"父类的构造方法\");\r\n    }\r\n    public void fm(){\r\n        System.out.println(\"调用父类fm()方法\");\r\n    }\r\n}\r\nclass Son extends Father{\r\n    public void sm(){\r\n        System.out.println(\"调用子类sm()方法\");\r\n        this.fm();	// this 会先从本类中找，如果找不到则会去父类中找\r\n    }\r\n}\r\n\r\npublic class Test {\r\n    public static void main(String[] args) {\r\n        Son obj = new Son();\r\n        obj.sm();\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n### 同一个类中构造器互相调用\r\n\r\n`this` 可以作为类中构造器相互调用的特殊格式\r\n\r\n```java\r\nthis();	// 调用本类的无参构造器\r\nthis(实参列表);	// 调用本类的有参构造器\r\n```\r\n\r\n注意：\r\n\r\n- 不能出现递归调用，如果一个类中声明了 n 个构造器，则最多有 n - 1 个构造器被调用\r\n- `this()` 和 `this(实参列表)`只能在构造器首行，在类的一个构造器中，最多只能声明一个 `this(参数列表)`\r\n\r\n```java\r\nclass Person {\r\n    private String name;\r\n    private int age;\r\n    // 无参构造\r\n    public Person(){\r\n        // this(\"\",18);    // 调用本类有参构造器\r\n    }\r\n    // 有参构造\r\n    public Person(String name){\r\n        this();     // 调用本类的无参构造器\r\n        this.name = name;\r\n    }\r\n    // 有参构造\r\n    public Person(String name, int age){\r\n        this(name);     // 调用本类中有一个String参数的构造器\r\n        this.age = age;\r\n    }\r\n    public String getInfo(){\r\n        return \"姓名：\" + this.name + \"，年龄：\" + this.age;\r\n    }\r\n}\r\n\r\npublic class Test {\r\n    public static void main(String[] args) {\r\n        Person obj = new Person(\"张三\", 18);\r\n        System.out.println(obj.getInfo());	// 姓名：张三，年龄：18\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n## 重写(Override)\r\n\r\n重写（Override）是指子类定义了一个与其父类中具有相同名称、参数列表和返回类型的方法，并且子类方法的实现覆盖了父类方法的实现\r\n\r\n重写的好处在于子类可以根据需要，定义特定于自己的行为。也就是说子类能够根据需要实现父类的方法。这样，在使用子类对象调用该方法时，将执行子类中的方法而不是父类中的方法\r\n\r\n```java\r\nclass Animal{\r\n    public void saying(){\r\n        System.out.println(\"你好\");\r\n    }\r\n}\r\nclass Dog extends Animal{\r\n    public void saying(){\r\n        System.out.println(\"Hello\");\r\n    }\r\n}\r\nclass Test {\r\n    public static void main(String[] args) {\r\n        Animal a = new Animal();\r\n        Animal b = new Dog();\r\n        a.saying();     // 你好\r\n        b.saying();     // Hello\r\n    }\r\n}\r\n```\r\n\r\n**方法的重写规则**\r\n\r\n- 参数列表与被重写方法的参数列表必须完全相同。\r\n- 返回类型与被重写方法的返回类型可以不相同，但是必须是父类返回值的派生类\r\n- 访问权限不能比父类中被重写的方法的访问权限更低。例如：如果父类的一个方法被声明为 public，那么在子类中重写该方法就不能声明为 protected\r\n- 父类的成员方法只能被它的子类重写\r\n- 声明为 final 的方法不能被重写\r\n- 声明为 static 的方法不能被重写，但是能够被再次声明\r\n- 子类和父类在同一个包中，那么子类可以重写父类所有方法，除了声明为 private 和 final 的方法\r\n- 子类和父类不在同一个包中，那么子类只能够重写父类的声明为 public 和 protected 的非 final 方法\r\n- 重写的方法能够抛出任何非强制异常，无论被重写的方法是否抛出异常。但是，重写的方法不能抛出新的强制性异常，或者比被重写方法声明的更广泛的强制性异常，反之则可以\r\n- 构造方法不能被重写\r\n- 如果不能继承一个类，则不能重写该类的方法', 0, '2024-12-21 18:31:34');
INSERT INTO `articles` VALUES (2, 1, NULL, 'Java', '实现数据封装：控制类或成员的可见性范围，需要依赖访问控制修饰符，也称为权限修饰符来控制\r\n\r\n## 成员变量 / 属性私有化\r\n\r\n私有化类的成员变量，提供公共的 `get` 和 `set` 方法，对外暴露获取和修改属性的功能\r\n\r\n使用 `private` 修饰成员变量\r\n\r\n```java\r\nclass Person{\r\n    // private 数据类型 变量名;\r\n    private String name;\r\n    private int age;\r\n\r\n\r\n    // 提供 getter 方法 / setter 方法，可以访问成员变量\r\n    public void setName(String name){\r\n        this.name = name;\r\n    }\r\n\r\n    public String getName(){\r\n        return name;\r\n    }\r\n\r\n    public void setAge(int age){\r\n        this.age = age;\r\n    }\r\n\r\n    public int getAge(){\r\n        return age;\r\n    }\r\n}\r\n\r\npublic class Test {\r\n    public static void main(String[] args) {\r\n        Person p = new Person();\r\n        // 实例变量私有化，跨类无法直接使用\r\n        /* p.name = \"张三\";\r\n        p.age = 18;\r\n        p.marry = true; */\r\n        p.setName(\"张三\");\r\n        System.out.println(p.getName());\r\n        p.setAge(20);\r\n        System.out.println(p.getAge());\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n## 私有化构造方法\r\n\r\n在Java中，构造方法用于创建类的实例。通过将构造方法设置为私有，可以防止类在外部被实例化。这种技术通常用于单例模式（Singleton Pattern）中\r\n\r\n- **实现私有化构造方法的步骤**\r\n  1. **定义私有构造方法**：将类的构造方法设置为私有\r\n  2. **提供公共静态方法**：通过公共静态方法来获取类的唯一实例\r\n\r\n```java\r\nclass Singleton {\r\n    // 私有静态实例，防止被引用(唯一实例)\r\n    private static Singleton instance;\r\n    private int a;\r\n    // 私有构造方法，防止被实例化\r\n    private Singleton() {}\r\n    // 公共静态方法，提供唯一实例\r\n    public static Singleton getInstance() {\r\n        if (instance == null) {\r\n            instance = new Singleton();\r\n        }\r\n        return instance;\r\n    }\r\n    public void setA(int a){\r\n        this.a = a;\r\n    }\r\n    public int getA(){\r\n        return this.a;\r\n    }\r\n}\r\npublic class Test {\r\n    public static void main(String[] args) {\r\n        Singleton obj = Singleton.getInstance();\r\n        obj.setA(2);\r\n        System.out.println(obj.getA());\r\n    }\r\n}\r\n```\r\n\r\n\r\n\r\n## 嵌套类实现私有化\r\n\r\n**嵌套类**\r\n\r\n- 嵌套类是定义在另一个类内部的类。嵌套类可以访问外部类的所有成员，包括私有字段和方法\r\n\r\n**嵌套类实现私有化**\r\n\r\n- 通过将类定义为嵌套类，可以控制其访问权限，防止类在外部被直接实例化\r\n\r\n```java\r\nclass OuterClass{\r\n    // 公共字段\r\n    public int num = 10;\r\n    // 私有字段\r\n    private String message = \"Hello\";\r\n    public String getMessage(){\r\n        return this.message;\r\n    }\r\n    // 嵌套类\r\n    private class InnerClass{\r\n        public void displayMessage(){\r\n            System.out.println(\"Message\");\r\n        }\r\n    } \r\n    // 公共方法，创建嵌套类实例并调用其方法\r\n    public void showMessage(){\r\n        InnerClass inner = new InnerClass();\r\n        inner.displayMessage();     // Message\r\n        System.out.println(getMessage());   // Hello\r\n        System.out.println(num);        // 10\r\n    }\r\n}\r\npublic class Test {\r\n    public static void main(String[] args) {\r\n        OuterClass outer = new OuterClass();\r\n        outer.showMessage();\r\n    }\r\n}\r\n```\r\n\r\n', 0, '2024-12-21 19:00:50');

-- ----------------------------
-- Table structure for articles_classify
-- ----------------------------
DROP TABLE IF EXISTS `articles_classify`;
CREATE TABLE `articles_classify`  (
  `article_id` bigint NOT NULL,
  `classify_id` bigint NOT NULL,
  INDEX `articles_classify_fk_1`(`article_id`) USING BTREE,
  INDEX `articles_classify_fk_2`(`classify_id`) USING BTREE,
  CONSTRAINT `articles_classify_fk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `articles_classify_fk_2` FOREIGN KEY (`classify_id`) REFERENCES `classify` (`classify_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of articles_classify
-- ----------------------------
INSERT INTO `articles_classify` VALUES (1, 1);
INSERT INTO `articles_classify` VALUES (2, 1);

-- ----------------------------
-- Table structure for classify
-- ----------------------------
DROP TABLE IF EXISTS `classify`;
CREATE TABLE `classify`  (
  `classify_id` bigint NOT NULL AUTO_INCREMENT,
  `classify_name` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`classify_id`) USING BTREE,
  UNIQUE INDEX `classify_name`(`classify_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of classify
-- ----------------------------
INSERT INTO `classify` VALUES (5, 'css');
INSERT INTO `classify` VALUES (7, 'go');
INSERT INTO `classify` VALUES (4, 'html');
INSERT INTO `classify` VALUES (1, 'java');
INSERT INTO `classify` VALUES (2, 'javascript');
INSERT INTO `classify` VALUES (6, 'php');
INSERT INTO `classify` VALUES (3, 'python');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `userid` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sex` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '男',
  `email` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tel` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE,
  UNIQUE INDEX `tel`(`tel`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, '张三', '女', '123456@qq.com', '14e1b600b1fd579f47433b88e8d85291', '12345678901', '2024-12-21 18:31:01');
INSERT INTO `users` VALUES (2, '李四', '男', '5555@qq.com', '14e1b600b1fd579f47433b88e8d85291', '19876543210', '2024-12-21 18:56:20');

SET FOREIGN_KEY_CHECKS = 1;
