<?php
namespace Home\Controller;
/*
传入自动加载方法
*/
use \Frame\Libs\BaseController;
use \Home\Model\CategoryModel;/*引入首页模型类*/
use \Home\Model\ArticleModel;/*引入首页模型类*/
final class IndexController extends BaseController{
  public function Index() /*对应的action()方法*/
  {
     $this->smarty->display("index.html");
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
    public function  showTop()
    {
        $categoryId = 0;
        if(!empty($_GET['cate']))
        {
            $categoryId = CategoryModel::getInstance()->Model_categoryGet($_GET['cate']);
            $where = "article.category_id in (";
            foreach($categoryId as $arr)
            {
                $where .= "{$arr},";
            }
            $where = trim($where,',');
            $where .= ') ';
            $where .= "AND article.top = 1 ";
            $contents=ArticleModel::getInstance()->fetchWithJoin("$where");
            $this->smarty->assign("articles",$contents);
            $this->smarty->display("common/top.html");
        }else{

        }
    }
    public function showFilter()
    {

        $categoryId = 0;
        //获取当前选中的父级分类
        if(!empty($_GET['cate']))
        {
            $categoryId = $_GET['cate'];
        }
        $cateObj =CategoryModel::getInstance();
        $data = $cateObj->fetchAll();
        $categorys = CategoryModel::getInstance()->categoryList($data);
        $sonCategorys = array();
        foreach($categorys as $arr)
        {
            if($arr['pid'] == $categoryId)
            {
                $sonCategorys[] = $arr;
            }
        }

        $this->smarty->assign("fatherId",$categoryId);
        $this->smarty->assign("sonCategorys",$sonCategorys);
        $this->smarty->display("common/filter.html");
    }
    public function showContent()
    {
        $totalCount=0;
        //content没进行分页处理
        $cur = 0;
        $pageSize=10;
        if(!empty($_GET['cate']))
        {
            //content 页面需要cate参数 但cate是filter页面的参数，content拿不到，这里传给content
            $cate=$_GET['cate'];
            $this->smarty->assign("cate",$cate);
            $categoryId = CategoryModel::getInstance()->Model_categoryGet($_GET['cate']);
            $where = "article.category_id in (";
            foreach($categoryId as $arr)
            {
                $where .= "{$arr},";
            }
            $where = trim($where,',');
            $where .= ') ';
            if(  (!empty($_GET['cur'])) &&  (!empty($_GET["pageSize"])) )
            {
                $cur=$_GET['cur'];
                $pageSize=$_GET['pageSize'];
                $cur= ($cur-1)*$pageSize;
            }
            $contents=ArticleModel::getInstance()->fetchWithJoin("$where",$cur,$pageSize);
        }else{
            $contents=ArticleModel::getInstance()->fetchWithJoin("2>1",$cur,$pageSize);
        }


        $this->smarty->assign("articles",$contents);
        $this->smarty->display("common/content.html");

    }
    public function showLaypage()
    {
        if(!empty($_GET['cate']))
        {
            $cate=$_GET['cate'];
            $categoryId = CategoryModel::getInstance()->Model_categoryGet($_GET['cate']);
            $where = "article.category_id in (";
            foreach($categoryId as $arr)
            {
                $where .= "{$arr},";
            }
            $where = trim($where,',');
            $where .= ') ';
            $totalCount=ArticleModel::getInstance()->Count($where);
        }
        else{
            $cate = 0;
            $totalCount=ArticleModel::getInstance()->Count();
        }
        $this->smarty->assign("totalArticle",$totalCount);
        $this->smarty->assign("cate",$cate);
        $this->smarty->display("common/laypage.html");
    }

    public function showFooter()
    {
        $this->smarty->display("common/footer.html");
    }
}
 ?>
