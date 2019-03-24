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
        $categorys = CategoryModel::getInstance()->categoryList($data);
        $articles=ArticleModel::getInstance()->fetchWithJoin($data);


        $this->smarty->assign(array(
            'categorys'=>$categorys,
            'articles' =>$articles
        ));
        $this->smarty->display("Article/index.html");
    }
    public function selectClass()
    {
        $val = $_POST['val'];
        $categoryId = CategoryModel::getInstance()->Model_categoryGet($val);

    }

}
