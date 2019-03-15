<?php
 namespace Frame\Libs;
 /*基础抽象模型类n*/
use \Frame\Vendor\PDOWrapper;
 abstract class BaseModel
 {
   /*pod*/
   protected $pdo = NULL;
   //模型数组
   protected static $arryModeObj = array();

   public function __construct()
   {
     $this->pdo = new PDOWrapper();
   }
   // 单例，公共静态模型类
   public static function getInstance()
   {
     //获取静态方式调用的类名  (防止字符串传参要加空间）
     $modelClassName = get_called_class();
     if(!isset( self::$arryModeObj[$modelClassName] ) )
     {
       self::$arryModeObj[$modelClassName] = new $modelClassName();
     }
      return self::$arryModeObj[$modelClassName];
   }
 }

 ?>
