<?php
 namespace Frame;
 //框架初始类
 final class Frame{
    public static function run()
    {
      //静态方法内只能使用self::来调用静态资源 不能用$this
        self::initCharset();//初始化字符集
        self::initConfig();//配置文件
        self::initRoute();//路由参数
        self::initConst();//常量目录设置
        self::initAutoLoad();//类的自动加载
        self::initDispatch();//请求分发

    }
    private static  function initCharset()
    {
        header("content_type:text/html; charset=utf-8 ");
    }
    private static function initConfig()
    {
      // 不同的目录下加载不同的配置文件

      $GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
    }
    // pca 三个参数

    private static function initRoute()
    {
        $p = $GLOBALS['config']['default_platform'];// 入口文件
        $c = isset($_GET['c'])?$_GET['c']:$GLOBALS['config']['default_controller'];//判断 是否设置控制器,若没有，采用配置文件中默认的控制器
        $a = isset($_GET['a'])?$_GET['a']:$GLOBALS['config']['defalut_action'];//判断 是否设置控制器,若没有，采用配置文件中默认的控制器
        define('PLAT',$p);
        define('CONTROLLER',$c);
        define('ACTION',$a);
    }
    //静态方法目录
    private static function initConst()
    {
        //例如 ./home/View/Student/
        define("VIEW_PATH"   ,APP_PATH."View".DS.CONTROLLER.DS);
        define("FRAME_PATH",ROOT_PATH."Frame".DS);
    }
    /*
     需要控制器的类，就加载文件:控制器.class.php
    */
    private static function initAutoLoad()
    {
      //将空间中的类名转换为真实的类文件路径
      // 空间中 \Home\Controller\StudentController
      //真实的类文件./Home/Controller/StudentController.class.php
      spl_autoload_register(function($className){
          $filename = ROOT_PATH.str_replace("\\","/",$className).".class.php";
          if(file_exists($filename)) require_once($filename);
      });
    }
    private static function initDispatch()
    {
      //构建控制器类名：\Home\Controller\StudentController
      $className =  "\\".PLAT."\\"."Controller"."\\".CONTROLLER."Controller";
      //echo " $className";
      $controllerObj = new $className();
      //调用控制器中的方法 方法里创建模型
      $actionName=ACTION;//ACTION是35行定义的行为器
      //echo "$actionName";
      $controllerObj->$actionName();//index();
    }
 }
 ?>
