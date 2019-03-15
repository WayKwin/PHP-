<?php
//前台的配置文件，数组形式
//php中数字 类似map
 return array(
   //数据库类型
  'db_type'  => 'mysql',
  'db_port' => '3306',
  'db_host' => 'localhost',
  'db_name' => 'student',
  'db_user' => 'waykwin',
  'db_password' =>'123456',
  /* PDO创建 字符集不识别 utf-8 去掉 '-'*/
  'db_charset' =>'utf8',
  // 前端的默认url参数
  //默认平台就是url入口，即前台的入口
  'default_platform' =>'home',
  'default_controller'=>'Index',// 默认的控制器一般是首页
  'defalut_action' =>'index'//

 );
 ?>
