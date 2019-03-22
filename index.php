<?php
define('DS',DIRECTORY_SEPARATOR);//目录分隔符 统一 windows和linux的 ‘/’或者'\'
define('ROOT_PATH',getcwd().DS);//网站的根目录
define('APP_PATH',ROOT_PATH.'Home'.DS);//应用目录  前台home 后台 admin
 // 包含头文件
//require_once(ROOT_PATH."Frame".DS."Frame.class.php");
 //框架初始化 命名空间的路径用\
 //Frame\Frame::run();
 require_once ("./Frame/Vendor/Captcha.class.php");
 $captcha=new \Frame\Vendor\Captcha();








 /*测试 PDOWrapper对象*/
 /*$pdo = new \Frame\Vendor\PDOWrapper();*/
/*1.查看类型*/
/* var_dump($pdo);*/
/*2.插入数据*/
 /*$pdo->exec("INSERT INTO `stu` (`id`, `name`) VALUES ('12', 'sb')");
 $pdo->exec("INSERT INTO `stu` VALUES ('13','sj')");*/
/*3.查找一行数据*/
 /*$result = $pdo->fetchOne("SELECT * FROM `stu`");
 print_r($result);*/
/*4.获取全部数据*/
 /*$result = $pdo->fetchALL("SELECT * FROM `stu`");
 print_r($result);*/
/*5. 获取数据多少行*/
 /*$result = $pdo->rowCount("SELECT * FROM `stu`");
 print_r($result);*/

 /*测试Smarty*/
//use Frame\Vendor\Smarty;
//$obj =  new Smarty();
 ?>
