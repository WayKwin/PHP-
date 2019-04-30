<?php
 namespace Admin\Model;
 use \Frame\Libs\BaseModel;
 final class UserModel extends BaseModel
 {
     protected  $table = "user";
   public function fetchAll()
   {
     //构建查询语句 结果返回二维数组
    // $sql =  "SELECT id,username,name,tel,last_login_ip,last_login_time,status,role,addate From {$this->table} ORDER BY id ";
       $sql =  "SELECT * From {$this->table} ORDER BY id ";
     return $this->pdo->fetchAll($sql);
   }
   public function deleteById($id)
   {
     $sql1 = "DELETE FROM {$this->table} WHERE id=$id";
     $sql2 = "DELETE FROM `user_info` WHERE user_id=$id";
     $sql3 = "DELETE FROM 'article' WHERE user_id = $id";
      return $this->pdo->exec($sql1) && $this->pdo->exec($sql2) && $this->pdo->exec($sql3);
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
      if( $this->pdo->exec($sql))
      {
         return  $this->addUser_Info($username);
      }
      else
      {
          return 0;
      }
   }
   public function addUser_Info($username)
   {
       $result = $this->pdo->fetchOne( "select id from $this->table where  username='$username'");
       $id = $result['id'];
       $sql =  " INSERT INTO `user_info` values ('$id','https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg',NULL,'100')";
       return $this->pdo->exec($sql);
   }

 }
 ?>
