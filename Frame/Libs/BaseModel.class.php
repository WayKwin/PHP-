<?php
 namespace Frame\Libs;
 /*基础抽象模型类n*/
use \Frame\Vendor\PDOWrapper;
 abstract class BaseModel
 {
   /*pod*/
   protected $pdo = NULL;
   protected $table='';
   //模型数组
   protected static $arryModeObj = array();

   public function __construct()
   {
     $this->pdo = new PDOWrapper();
   }
     public function fetchAll()
     {
         $sql =  "SELECT * From {$this->table} ORDER BY id ";
         return $this->pdo->fetchAll($sql);
     }
     public function query($cols=array("*"),$cond="2>1")
     {
       $str="";
       foreach($cols as $col)
       {
           $str.="$col,";
       }
       $str=rtrim($str,",");
       $sql="SELECT $str From {$this->table} WHERE {$cond}";
       return $this->pdo->fetchAll($sql);
     }
     public function fetchOne($cond="2>1")
     {
         $sql =  "SELECT * From {$this->table} WHERE {$cond} ORDER BY id ";
         return $this->pdo->fetchOne($sql);
     }
     public function update($data,$id)
     {
         $str="";
         foreach($data as $key=>$value)
         {
             $str.="$key='$value',";
         }
         //去掉末尾逗号
         $str=rtrim($str,",");
         $sql =  "UPDATE {$this->table} SET {$str} WHERE id=$id";
         return $this->pdo->exec($sql);
     }
     public function insert($data)
     {
         $str="";
         foreach($data as $key=>$value)
         {
             $str.="'$value',";
         }
         $str=rtrim($str,",");
         $sql =  "insert into {$this->table} values(NULL,$str)";
         return $this->pdo->exec($sql);
     }
     public function delete($col,$val)
     {
         $sql = "DELETE FROM {$this->table} WHERE $col=$val;";
         return $this->pdo->exec($sql);
     }
     public function RowCount($col,$cond)
     {
         $sql = "SELECT count(*) FROM {$this->table} WHERE $col='$cond'";
         return $this->pdo->rowCount($sql);
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
