<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mr.wei
 * Date: 2019/3/24
 * Time: 16:08
 */
namespace Admin\Controller;
use \Admin\Model\ArticleModel;
use \Admin\Model\CategoryModel;
use \Frame\Libs\BaseController;
final class ArticleController extends BaseController{
    public function index()
    {
        $cateObj =CategoryModel::getInstance();
        $data = $cateObj->fetchAll();
        //对数据进行递归分类(dfs)
        $data = CategoryModel::getInstance()->categoryList($data);
        //print_r($data);
        $this->smarty->assign("categorys",$data);

        $this->smarty->display("Article/index.html");
    }
}
