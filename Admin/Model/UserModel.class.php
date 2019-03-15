<?php
 namespace Admin\Model;
 use \Frame\Libs\BaseModel;
 final class UserModel extends BaseModel
 {
   public function fetchAll()
   {
     //构建查询语句 结果返回二维数组
     $sql =  "SELECT id,username,name,tel,last_login_ip,last_login_time,status,role,addate From user ORDER BY id ";
     return $this->pdo->fetchAll($sql);
   }
   public function deleteById($id)
   {
     $sql = "DELETE FROM user WHERE id=$id";
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
      $sql="INSERT INTO user values(NULL,'$username','$password','$name','$tel','$last_login_ip','$last_login_time','$login_times','$status','$role','$addate')";
      return $this->pdo->exec($sql);
   }
   public function RowCount($col,$username)
   {
      $sql = "SELECT count(*) FROM user WHERE $col='$username'";
      return $this->pdo->rowCount($sql);
   }

 }
 ?>
