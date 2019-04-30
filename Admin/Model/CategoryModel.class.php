<?php
namespace Admin\Model;
use \Frame\Libs\BaseModel;
final class CategoryModel extends BaseModel
{
    protected $table = "category";
    protected $aritcleTable="article";
    public function categoryList($arrs,$level=0,$pid=0)
    {
        static $category = array();
        foreach($arrs as $arr ) {
            if ($arr['pid'] == $pid) {
                $arr['level'] = $level;
                $category[] = $arr;
                $this->categoryList($arrs, $level + 1, $arr['id']);
            }
        }
        return $category;

    }
    public function Model_categoryDel($aimId)
    {
        //获取所有表Id
        $idArr=$this->query(array("id,pid"));
        if(!empty($idArr))
        {
            $this->delAllId($idArr,$aimId);
            return 1;
        }
        else
        {
            return 0;
        }
    }
    //dfs
    private function delAllId($idArr,$aimId)
    {
        foreach($idArr as $arr)
        {
            // 该分类的子分类也应该删除
            if($arr['pid']==$aimId)
            {
                //递归删除
                $this->delAllId($idArr,$arr['id']);
            }
        }
        //该分类下没有子分类，1.先删除该分类下所有文章，再删除该分类
        $this->deleteArticleByCategoryId($aimId);
        $this->delete('id',$aimId);
    }
    private function deleteArticleByCategoryId($id)
    {
        $sql = "Delete From {$this->aritcleTable} where category_id=$id";
        //执行失败表示该分类下没有文章
        $this->pdo->exec($sql);
    }
    //获取 该类别和该类别下所有类别
    public function Model_categoryGet($id)
    {
        $idArr=$this->query(array("id,pid"));
        $categoryId = array();
        $this->getAllId($idArr,$id,$categoryId);
        return $categoryId;
    }

    private function getAllId($idArr,$aimId,&$categoryId)
    {
        foreach($idArr as $arr)
        {
            if($arr['pid']== $aimId)
            {
                $this->getAllId($idArr,$arr['id'],$categoryId);
            }
        }
        array_push($categoryId,$aimId);
    }
    /**/
    public function countArticle($idArr,$aimId)
    {
       static $artCountArr = array();

       foreach($idArr as $arr)
       {
           if($arr['pid']== $aimId)
           {

               $arr['articleCount']=$this->countArticle($idArr,$arr['id']);
           }
       }
        return $this->fetchAllAticle($aimId);
    }
    private function fetchAllAticle($id)
    {
        $sql = "SELECT COUNT(*) From {$this->aritcleTable} WHERE category_id = $id ";
        // echo $sql;
        return;
        $this->pdo-exec($sql);
    }

}
?>
