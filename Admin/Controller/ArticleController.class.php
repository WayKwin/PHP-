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
    // 选中某分类  找出其和其子分类
    public function add()
    {
        $cateObj =CategoryModel::getInstance();
        $data = $cateObj->fetchAll();
        $categorys = CategoryModel::getInstance()->categoryList($data);

        $this->smarty->assign(
            'categorys',$categorys
        );
        $this->smarty->display("Article/add.html");

    }
    public function addArticle()
    {
        //没有安全处理
        if(!isset($_POST['data']))
        {
            echo 0;
            return;
        }
        $articleMsg=(array)json_decode($_POST['data'],true);


        //未登录
        if(!isset($_SESSION['uid']))
        {
            echo -1;
            return;
        }
        //加入额外信息
        $articleMsg['user_id'] =$_SESSION['uid'];
        $articleMsg['read_count'] = 0;
        $articleMsg['comment_count'] = 0;
        $articleMsg['praise'] = 0;
        $articleMsg['addate'] = date('Y-m-d h:i:s', time());
//        print_r($articleMsg);
//        die();
        if(ArticleModel::getInstance()->insert($articleMsg))
        {
            echo 1;
        }else{
            echo 0;
        }
    }
    public function selectClass()
    {
        $val = $_POST['val'];
        $categoryId = CategoryModel::getInstance()->Model_categoryGet($val);
        $this->smarty->assign(array(
            'categorys'=>$categoryId,
        ));
    }
    public function delArticle()
    {
        $id = $_POST['id'];

         if(ArticleModel::getInstance()->delete("id",$id))
         {
            echo 1;
         }
         else
         {
             echo 0;
         }
    }

}
