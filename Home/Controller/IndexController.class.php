<?php
namespace Home\Controller;
/*
传入自动加载方法
*/
use \Frame\Libs\BaseController;
use \Home\Model\CategoryModel;/*引入首页模型类*/
final class IndexController extends BaseController{
  public function Index() /*对应的action()方法*/
  {
     $categoryId=0;
     if(!empty($_GET['category']))
     {
        $categoryId = $_GET['category'];
     }
     $this->smarty->display("index.html");
  }
  public function getCategory()
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
      $fatherCategorys=json_encode($fatherCategorys);
      echo $fatherCategorys;

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
    public function showFilter()
    {

        $categoryId = 0;
        //获取当前选中的父级分类
        if(!empty($_GET['l1']))
        {
            $categoryId = $_GET['l1'];
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
        $categoryId = 0;
        if(!empty($_GET['l2']))
        {
            $categoryId = $_GET['l2'];
        }
        $this->smarty->display("common/content.html");

    }
    public function showFooter()
    {
        $this->smarty->display("common/footer.html");
    }
}
 ?>
