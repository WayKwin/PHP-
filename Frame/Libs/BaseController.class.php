<?php
 namespace Frame\Libs;
 //基础控制器类
 use \Frame\Vendor\Smarty;
 abstract class BaseController
{
  //Smarty实现视图控制器分离
  protected $samrty = NULL;

  public function __construct()
  {
    //Frame类中请求分发中调用
    $this->initSmarty();
  }
  protected  function denyAccess()
  {
     if(!isset($_SESSION['name']))
     {
         $this->jump("请登录","admin.php?c=User&a=Login",1);
     }
  }

  //私有的Smarty对象初始化
  private function initSmarty()
  {
      $smarty = new Smarty();
      $smarty->left_delimiter = '<{';//左定界符
      $smarty->right_delimiter = '}>';//右定界符
      # ./admin/view/News/
      $smarty->setTemplateDir(VIEW_PATH);//设置视图文件目录
      $smarty->setCompileDir(sys_get_temp_dir().DS."view".DS);//设置编译的目录
      $this->smarty = $smarty;
  }
  protected function jump($message,$url='?',$time=3)
  {
      $this->smarty->assign("message",$message);
      $this->smarty->assign("url",$url);
      $this->smarty->assign("time",$time);
      $this->smarty->display("Public/jump.html");
      die();
  }

}
 ?>
