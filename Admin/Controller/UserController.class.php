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
        $this->smarty->display("index.html");
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

        $this->smarty->display("Add.html");
    }
    public function addUser()
    {
      $data = $_POST['userRegInfo'];
      $arr = json_decode($data,$assoc=true);
      $addate = date('Y-m-d h:i:s', time());
      $ip = $this->getClientIP();
      //在win7以上 localhost默认 ipv6显示模式
      if($ip == '::1')
      {
        $ip = '127.0.0.1';
      }
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
    function getClientIP()
    {
        global $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
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
        $this->smarty->display("Edit.html");
    }
}
?>
