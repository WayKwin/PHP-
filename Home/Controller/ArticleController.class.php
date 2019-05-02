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

        ArticleModel::getInstance()->addReadCount($article_id);
        $content=ArticleModel::getInstance()->fetchOneWithJoin($article_id);
        $replys=ArticleModel::getInstance()->fetchAllReply($article_id,0,10,"reply.cur_floor");

        $this->smarty->assign("detail",$content);
        $this->smarty->assign("replys",$replys);
        $this->smarty->display("article/detail.html");
    }
    public function deleteReply()
    {
       $data = $_POST['data'];
       $data = (array)json_decode($data);
       $replyId = $data['reply_id'];
       $articleId = $data['article_id'];
       ArticleModel::getInstance()->deleteReplyCount($articleId);
       echo  ReplyModel::getInstance()->deleteReply($replyId);
    }
    public function uploadImg()
    {
       //上传文件
        $content =1;
        $retInfo = array(
         "code"=>0,
            "msg"=>"上传成功",
            "data"=>array(
                 "src"=>"./Public/img/vercode.jpg",
                 "title"=>"这是图片标题"
            )
        );
        $retJson = json_encode($retInfo);
        header('Content-Type:application/json; charset=utf-8');
        echo $retJson;
    }
    public function reply()
    {
        //$article_id = $_GET["article_id"];
        $msg = $_POST["data"];
        //json返回object强转一下
        $replyInfo=(array)json_decode($msg);

        //更新文章的最大楼层（+1）
        ArticleModel::getInstance()->addArticleMaxFloor($replyInfo['article_id']);

        $article_id = $replyInfo['article_id'];
        $max_floor = ArticleModel::getInstance()->fetchOne("id=$article_id")['max_floor'];

        $replyInfo['addate'] = date('Y-m-d h:i:s', time());
        $replyInfo['praise'] = 0;
        $replyInfo['cur_floor'] = $max_floor;
        $res = ReplyModel::getInstance()->insert($replyInfo);

        if($res)
        {
            //回复成功增加回复数
           ArticleModel::getInstance()->addReplyCount($replyInfo['article_id']);
            echo 1;
        }
        else
        {
            echo 0;
        }

        //echo $article_id;

    }
    public function add()
    {
        if(isset($_SESSION['user']))
        {
            $cateObj =CategoryModel::getInstance();
            $data = $cateObj->fetchAll();
            $categorys = CategoryModel::getInstance()->categoryList($data);
            $this->smarty->assign(
                'categorys',$categorys
            );
            $this->smarty->display("article/add.html");
        }else{
            $this->jump("请登录","?c=User&a=login");
        }

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
        if(!isset($_SESSION['user']))
        {
            echo -1;
            return;
        }
        //加入额外信息
        $articleMsg['user_id'] =$_SESSION['user']['uid'];
        $articleMsg['read_count'] = 0;
        $articleMsg['comment_count'] = 0;
        $articleMsg['praise'] = 0;
        $articleMsg['addate'] = date('Y-m-d h:i:s', time());
        $articleMsg['max_floor'] = 0;
        if(ArticleModel::getInstance()->insert($articleMsg))
        {
            echo 1;
        }else{
            echo 0;
        }
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
