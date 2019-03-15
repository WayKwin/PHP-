<?php
namespace Admin\Controller;
/*
传入自动加载方法
*/
use \Frame\Libs\BaseController;
use \Admin\Model\IndexModel;/*引入首页模型类*/
final class IndexController extends BaseController
{
    public function Index()/*对应的action方法 对应 View/Index/index.html*/ {
        // 后台默认展示静态首页 ?c=Index&a=Index
        $this->smarty->display("index.html");
        
    }
    public function Center()/*对应的action方法 对应 View/Index/index.html*/ {
        // 后台默认展示静态首页 ?c=Index&a=Index
        $this->smarty->display("Center.html");
    }
}
 ?>
