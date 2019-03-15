<?php
 namespace Frame\Vendor;
 /*PDO是全局空间的 注意不是Frame\vendor中的*/
 use \PDO;
 use \PDOException;
//定义最终的PDOWarpper
final class PDOWrapper
{
    private $pdo = NULL;
    //数据库的配置属性
    private $db_type;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_charset;
    //构造方法
    public function __construct(){
      $this->db_type = $GLOBALS['config']['db_type'];
      $this->db_host = $GLOBALS['config']['db_host'];
      $this->db_port = $GLOBALS['config']['db_port'];
      $this->db_user = $GLOBALS['config']['db_user'];
      $this->db_pass = $GLOBALS['config']['db_password'];
      $this->db_name = $GLOBALS['config']['db_name'];
      $this->db_charset = $GLOBALS['config']['db_charset'];
      $this->connecDb();
      $this->setErrMode();
    }
    private function connecDb()
    {   /* mysql: host = localhost;port = 3306;dbname = stu;charset = "utf-8";*/
      try{
      $dsn =  "{$this->db_type}:host={$this->db_host};port={$this->db_port};";
      $dsn .= "dbname={$this->db_name};charset={$this->db_charset}";
      //echo "$dsn,  $this->db_user, $this->db_pass";
      $this->pdo = new PDO($dsn,$this->db_user,$this->db_pass);
      }catch(PDOException $e){
        echo"<h2>创建POD对象失败</h2>";
        $this->ShowErrorMessage($e);
        die();
      }
    }
    private function setErrMode()
    {
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    public function exec($sql)
    {
      try
      {
        return $this->pdo->exec($sql);
      }catch(PODException $e){
        echo"<h2>sql语句错误</h2>";
        $this->ShowErrorMessage($e);
        die();
      }
    }
    private function ShowErrorMessage($e)
    {
        echo "PDO  Error：".$e->getCode();
        echo "<br> ErrorLine:".$e->getLine();
        echo "<br> ErrorFile:".$e->getFile();
        echo "<br> ErrorMessage:".$e->getMessage();

    }
    public function fetchOne($sql)
    {
      try{
          $PDOStatement = $this->pdo->query($sql);
          return $PDOStatement->fetch(PDO::FETCH_ASSOC);
      }catch(PDOException $e){
        $this->ShowErrorMessage($e);
        die();
      }
    }
    public function fetchAll($sql)
    {
      try{
        $PDOStatement = $this->pdo->query($sql);
        return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
      }catch(PDOException $e){
        $this->ShowErrorMessage($e);
        die();
      }
    }
    public function rowCount($sql)
    {
      try{
          $q= $this->pdo->query($sql);
          $rows=$q->fetch();
          return $rows[0];
      }catch(PDOException $e){
        $this->ShowErrorMessage($e);
        die();
      }
    }
}
 ?>
