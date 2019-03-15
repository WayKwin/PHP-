<?php
define('DS',DIRECTORY_SEPARATOR);//目录分隔符 统一 windows和linux的 ‘/’或者'\'
define('ROOT_PATH',getcwd().DS);//网站的根目录
#define('FRONT_PATH',ROOT_PATH.'Home'.DS);//前台的应用目录  frame要统一路径
define('APP_PATH',ROOT_PATH.'Admin'.DS);//应用目录  前台home 后台 admin
#echo ROOT_PATH.DS.",".FRONT_PATH;
#die();
 #echo  ROOT_PATH.DS."Frame".DS."Frame.class.php";
 // 包含头文件
require_once(ROOT_PATH."Frame".DS."Frame.class.php");
 //框架初始化 命名空间的路径用\
 Frame\Frame::run();
 ?>
