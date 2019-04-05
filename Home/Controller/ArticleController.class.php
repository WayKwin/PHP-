<?php
namespace Home\Controller;
/*
传入自动加载方法
*/
use \Frame\Libs\BaseController;
use \Home\Model\CategoryModel;/*引入首页模型类*/
use \Home\Model\ArticleModel;
use \Home\Model\ReplyModel;
final class ArticleController extends BaseController{
    public function index()
    {
        $article_id = $_GET["article_id"];
        $content=ArticleModel::getInstance()->fetchOneWithJoin($article_id);
        $replys=ArticleModel::getInstance()->fetchAllReply($article_id);

//        print_r($replys);
//        echo $replys;
        $this->smarty->assign("detail",$content);
        $this->smarty->assign("replys",$replys);
        $this->smarty->display("article/detail.html");
    }
    public function reply()
    {
        //$article_id = $_GET["article_id"];
        $msg = $_POST["data"];
        //json返回object强转一下
        $replyInfo=(array)json_decode($msg);
        $replyInfo['addate'] = date('Y-m-d h:i:s', time());
        $replyInfo['praise'] = 0;
        $res = ReplyModel::getInstance()->insert($replyInfo);
        if($res)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }

        //echo $article_id;

    }
    public function showHeader()
    {
        $this->smarty->display("common/header.html");
    }
    public function showColumn()
    {
        $cateObj =CategoryModel::getInstance();
        $data = $cateObj->fetchAll();
        $categorys = CategoryModel::getInstance()->categoryList($data);
        $fatherCategorys = array();
        foreach($categorys as $arr)
        {
            if($arr['level'] == 0)
            {
                $fatherCategorys[] = $arr;
            }
        }
        $this->smarty->assign("fatherCategorys",$fatherCategorys);
        $this->smarty->display("common/column.html");
    }
    public function showDetail()
    {
        $article_id = $_GET["article_id"];
        $content=ArticleModel::getInstance()->fetchOneWithJoin($article_id);
        echo $content;
        $this->smarty->assign("detail",$content);
        $this->smarty->display("common/detail.html");

    }
    public function showFooter()
    {
        $this->smarty->display("common/footer.html");

    }
}
