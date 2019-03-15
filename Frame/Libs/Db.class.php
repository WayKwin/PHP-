<?php
namespace Frame\Libs;
 final class Db
 {
   private static $boj = NULL;
   private $db_host;
   private $db_usr;
   private $db_pass;
   private $db_name;
   private $charset;

   private function _construct()
   {
     $this->db_host = $GLOBALS['config']['db_host'];
     $this->db_usr = $GLOBALS['config']['db_usr'];
     $this->db_pass = $GLOBALS['config']['db_pass'];
     $this->db_name= $GLOBALS['config']['db_name'];
     $this->db_charset = $GLOBALS['config']['db_charset'];
     $this->connecDb();
     $this->selectDb();
     $this->setCharset();
   }
   /*??*/
   private function __clone(){}

    public static function getInstance()
    {
      /*单例*/
      if(!self::$obj instanceof self)
      {
        self::$obj = new self();
      }
      return self::$obj;
    }
    private function connectDb()
    {
      if(!@mysql_connec($this->db_host,$this->db_user,$this->db_pass))
      {
        die("连接MySQL服务器失败！");
      }
    }
    private function selectDb()
    {
      if(!mysql_select_db($this->db_name))
      {
          die("选择数据库{$this->db_name}失败!");
      }
    }
    private function selectCharset()
    {
      $this->exec("SET NAMES($this->charset)");
    }
    /*
    执行  insert,set,update,delete,create,drop等
    returns bool
    */
    private function exec($sql)
    {
      $sql = strtolower($sql);
      if(substr($sql,0,6) == 'select')
      {
        die("无法执行select");
      }
      return mysql_query($sql);
    }
    /*
    查询
    返回的数组指针
    */
    private function query($sql)
    {
      $sql = strtolower($sql);
      if(substr($sql,0,6) != 'select')
      {
        die("执行了非select语句");
      }
      return mysql_query($sql);
    }
    //巩固的获取单行记录的方法（一维数组）
    public function fetchOne($sql,$type = 3)
    {
      $result = $this->query($sql);
      $types = array(
        1 => MYSQL_NUM,/*返回索引数组*/
        2 => MYSQL_BOTH,/*返回两者数组*/
        3 => MYSQL_ASSOC,/* 返回关联数组*/
      );
      /*parameter 1 query返回的结果集数组指针,2返回数组类型*/
      return mysql_fetch_array($result,$types[$type]);
    }
    public function fetchAll($sql,$type =3)
    {
      $result = $this->query($sql);
      //定义返回数据类型；
      $types = array(
        1 => MYSQL_NUM,
        2 => MYSQL_BOTH,
        3 => MYSQL_ASSOC,
      );
      /*获取的结果集数组不为空*/
      while($row = mysql_fetch_array($result,$types[$type]));/*row是一维数组*/
      {
        $arrs[] = $row;
      }
      return $arrs;
    }
    public function rowCount($sql)
    {
      $result = $this->query($sql);
      return mysql_num_rows($result);
    }
 }
 ?>
