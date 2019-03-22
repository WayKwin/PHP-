<?php
namespace Admin\Controller;
/*
传入自动加载方法
*/
/*公共视图控制器 没有模型类*/
use \Frame\Libs\BaseController;
final class CategoryController extends BaseController{
    public function index()
    {
        $this->smarty->display("Category/index.html");
    }
}
?>
