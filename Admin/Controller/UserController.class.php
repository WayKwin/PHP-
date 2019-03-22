<?php
namespace Admin\Controller;
/*
传入自动加载方法
*/

use Admin\Model\UserModel;
use \Frame\Libs\BaseController;
final class UserController extends BaseController{
    public function Index()/*对应的action方法 对应 View/Index/index.html*/
    {
        $userObj = UserModel::getInstance();
        $arrs = $userObj->fetchAll();
        $this->smarty->assign("arrs",$arrs);
        $this->smarty->display("User/index.html");
    }
    public function checkUserName()
    {
      //$name = $_POST['name'];
      $name = $_POST['name'];
      $userObj = UserModel::getInstance();
      $result = $userObj->RowCount('username',$name);
      //证明没有重复
      if($result == 0)
        echo 1;
      else
        echo 0;
    }
    public function checkName()
    {
      //$name = $_POST['name'];
      $name = $_POST['name'];
      $userObj = UserModel::getInstance();
      $result = $userObj->RowCount('name',$name);
      if($result == 0)
        echo 1;
      else
        echo 0;
    }
    //public function showUserTable()
    //{
        //$indexObj = IndexModel::getInstance();
        //$arrs = $indexObj->fetchAll();
        ////print_r ($arrs);
        //$userJson = json_encode($arrs);
        //$retJson =
        //"{\"code\":0,\"msg\":\"\",\"count\":1,\"data\":$userJson}";
          //header('Content-Type:application/json; charset=utf-8');
        //echo $retJson;
    //}
    public function add()
    {

        $this->smarty->display("User/Add.html");
    }
    public function addUser()
    {
      $data = $_POST['userRegInfo'];
      $arr = json_decode($data,$assoc=true);
      $addate = date('Y-m-d h:i:s', time());
      $ip = $this->getClientIP();
      //在win7以上 localhost默认 ipv6显示模式
      $arr['last_login_ip'] = $ip;
      $arr['last_login_time'] = $addate;
      $arr['addate'] = $addate;
      $arr['login_times'] = 0;
      $arr['status'] =  1;

      $userObj = UserModel::getInstance();
      $result = $userObj->insertUser($arr);
      if($result == 1)
        echo 1;
      else
        echo 0;
    }
    private function getClientIP()
    {
        global $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
        if($ip=="::1")
        {
            $ip="127.0.0.1";
        }
        return $ip;
    }

    public function  deleteUser()
    {
        $id = $_GET['id'];
        if(isset($id))
        {
          $userObj = UserModel::getInstance();
          if($userObj->deleteById($id))
          {
              //成功
            echo '1';
          }
          else
          {
            echo '0';
          }
        }
        else
        {
           echo '0';
        }
    }
    public function edit()
    {
        $this->smarty->display("User/Edit.html");
    }
    public function checkLogin()
    {
        //初始化返回信息
        $retInfo = array(
         "flag" =>"0",
         "name" =>"null",
        );
        $msgData= $_POST['loginMsg'];
        $arr = json_decode($msgData,$assoc=true);

        $username = $arr['username'];
        $password= $arr['password'];

        $userObj = UserModel::getInstance();

        //如果没查到 user  $user返回 bool false
        $user = $userObj->fetchOne(" username='$username' AND password='$password' ");
        // empty=false
        //用户存在
        if(!empty($user))
        {
            $data["last_login_ip"] =$this->getClientIP();
            $data["last_login_time"] = date('Y-m-d h:i:s', time());
            $data["login_times"] =$user["login_times"]+1;
            $updateResult=$userObj->update($data,$user['id']);
            //全部验证成功
            if(!empty($updateResult))
            {
                $retInfo['flag'] = "1";
                $retInfo['name'] = $user["name"] ;
                $_SESSION['uid'] = $user['id'];
                $_SESSION['name'] = $user['name'];
            }
            //更新失败
            else
            {
                $retInfo['flag']="-2";
            }
        }
        else
        {
           $retInfo['flag']="0";
        }
        $result = json_encode($retInfo);
        echo $result;
    }
    public function login()
    {
        $this->smarty->display("User/Login.html");
    }
    public function logout()
    {
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        session_destroy();
        //setcookie(session_id(),false);
        $this->jump("您已退出登录","admin.php?c=User&a=login",1);
    }
}
?>
