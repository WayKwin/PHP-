<?php
 namespace Admin\Model;
 use \Frame\Libs\BaseModel;
 final class UserModel extends BaseModel
 {
     private $table = "user";
   public function fetchAll()
   {
     //构建查询语句 结果返回二维数组
    // $sql =  "SELECT id,username,name,tel,last_login_ip,last_login_time,status,role,addate From {$this->table} ORDER BY id ";
       $sql =  "SELECT * From {$this->table} ORDER BY id ";
     return $this->pdo->fetchAll($sql);
   }
   public function fetchOne($cond="2>1")
   {
       $sql =  "SELECT * From {$this->table} WHERE {$cond} ORDER BY id ";
       return $this->pdo->fetchOne($sql);
   }
   public function deleteById($id)
   {
     $sql = "DELETE FROM {$this->table} WHERE id=$id";
      return $this->pdo->exec($sql);
   }
   public function insertUser($arr)
   {
      $username=$arr['username'];
      $name = $arr['name'];
      $password=$arr['password'];
      $tel=$arr['tel'];
      $last_login_ip= $arr['last_login_ip'];
      $last_login_time= $arr['last_login_time'];
      $role= $arr['role'];
      $status = $arr['status'];
      $addate = $arr['addate'];
      $login_times = $arr['login_times'];
      $sql="INSERT INTO {$this->table} values(NULL,'$username','$password','$name','$tel','$last_login_ip','$last_login_time','$login_times','$status','$role','$addate')";
      return $this->pdo->exec($sql);
   }
   public function update($data,$id)
   {
       $str="";
       foreach($data as $key=>$value)
       {
           // last_login_ip = '127.0.0.1', login_times='2',
          $str.="$key='$value',";
       }
        //去掉末尾逗号
       $str=rtrim($str,",");
       $sql =  "UPDATE {$this->table} SET {$str} WHERE id=$id";
       return $this->pdo->exec($sql);
   }
   public function RowCount($col,$username)
   {
      $sql = "SELECT count(*) FROM {$this->table} WHERE $col='$username'";
      return $this->pdo->rowCount($sql);
   }

 }
 ?>
