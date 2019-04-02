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
        $this->smarty->assign("categorys",$categorys);
        $this->smarty->display("Article/index.html");
    }
    public function showTable()
    {

        //分页显示
        $page = $_GET['page'];
        $pageSize = $_GET['pageSize'];
        //当前页的开始字段
        $cur = ($page-1)*$pageSize;
        $where="2>1 ";
        //选择新闻类别
        if(!empty($_GET['classid']))
        {
            $categoryId = CategoryModel::getInstance()->Model_categoryGet($_GET['classid']);
            $where .= "AND category_id in (";
            foreach($categoryId as $arr)
            {
                $where .= "{$arr},";
            }
            $where = trim($where,',');
            $where .= ') ';
        }
        //标题搜索
        if(!empty($_GET['keyword']))
        {
            $where.="AND title LIKE '%{$_GET['keyword']}%' ";
        }

        $articles=ArticleModel::getInstance()->fetchWithJoin($where,$cur,$pageSize);
        $dataArr=array();
        foreach($articles as $arr)
        {
            $dataArr[]=array(
             "id"=>$arr['id']
            ,'classname'=>$arr['classname']
            ,'title'=>$arr['title']
            ,'content'=>$arr['content']
            ,'author'=>$arr['name']
            ,'addate'=>$arr['addate']
            ,'top'=>$arr['top']
            );
        }
        $count = $articles=ArticleModel::getInstance()->Count($where);
        $this->retJsonMsg(0,"",$count,$dataArr);
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
        if(ArticleModel::getInstance()->insert($articleMsg))
        {
            echo 1;
        }else{
            echo 0;
        }
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
