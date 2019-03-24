<?php
namespace Home\Controller;
/*
传入自动加载方法
*/
use \Frame\Libs\BaseController;
use \Home\Model\IndexModel;/*引入首页模型类*/
final class IndexController extends BaseController{
    //一个控制器目录对应一个视图目录
   // Index控制器目录对应Index视图目录， index控制器类中包含很多action方法， 每个action(add)对应 view/index/add.html
  public function Index() /*对应的action()方法*/
  {
    //创建模型层对象  //注意参数是字符窜， 类要加上空间+类名
    $modeObj =  IndexModel::getInstance();
   //拉取后台数据
    $arrs  = $modeObj->fetchAll();
    $this->smarty->assign("arrs",$arrs);
    //目录在initSmarty中设置了viewPath
    $this->smarty->display("Index/index.html");
  }
  public function delete()
  {
    $id = $_GET['id'];
    echo $id;
    $this->jump("删除成功","?c=Index");
   // 创建模型类，  模型类中实现  deleteById的方法
  }
}
 ?>
