<?php
namespace Admin\Controller;
/*
传入自动加载方法
*/
/*公共视图控制器 没有模型类*/

use \Admin\Model\CategoryModel;
use \Frame\Libs\BaseController;
final class CategoryController extends BaseController{
    public function index()
    {
        $cateObj =CategoryModel::getInstance();
        $data = $cateObj->fetchAll();
        //对数据进行递归分类(dfs)
        $data = CategoryModel::getInstance()->categoryList($data);
        //print_r($data);
        $this->smarty->assign("categorys",$data);

        $this->smarty->display("Category/index.html");
    }
    public function add()
    {
        $cateObj =CategoryModel::getInstance();
        $data = $cateObj->fetchAll();
        $data = CategoryModel::getInstance()->categoryList($data);
        $this->smarty->assign("categorys",$data);
        $this->smarty->display("Category/add.html");
    }
    public function insertCategory()
    {
       $data = $_POST['data'];
       $data = json_decode($data);
       $cateObj =CategoryModel::getInstance();
       if($cateObj->insert($data) == 1)
       {
           echo 1;
       }
       else
       {
           echo 0;
       }
    }
    public function editCategory()
    {
        //目前只支持修改名字
        $id = $_POST["id"];
        $classname = $_POST["classname"];
        $arr =array(
         "classname"  =>$classname
        );
        $result  = CategoryModel::getInstance()->update($arr,$id);
        if($result)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    public function delCategory()
    {
        $id = $_POST['id'];
        if(isset($id))
        {
            $userObj = CategoryModel::getInstance();
            //要将该分类下所有删除
            if($userObj->Model_categoryDel($id))
            {
                //成功
                echo '1';
            }
            else
            {
                echo '0';
            }
        }
        else
        {
            echo '0';
        }
    }
}
?>
