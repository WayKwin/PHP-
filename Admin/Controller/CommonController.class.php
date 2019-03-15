<?php
namespace Admin\Controller;
/*
传入自动加载方法
*/
/*公共视图控制器 没有模型类*/
use \Frame\Libs\BaseController;
final class CommonController extends BaseController{
    public function top()
    {
        $this->smarty->display("top.html");

    }
    public function footer()
    {
        $this->smarty->display("footer.html");

    }
    public function left()
    {
        $this->smarty->display("left.html");

    }
}
?>
