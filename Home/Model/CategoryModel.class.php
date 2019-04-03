<?php
namespace Home\Model;
use \Frame\Libs\BaseModel;
final class CategoryModel extends BaseModel
{
    protected $table = "category";
    protected $aritcleTable="article";
    //分类和分类下的文章数
    public function fetchAllWithCount()
    {
        $sql = "SELECT category.*,count(article.id) as records FROM {$this->table} ";
        $sql .="LEFT JOIN article ON category.id=article.category_id ";
        $sql .= "GROUP BY category.id";
        return $this->pdo->fetchAll($sql);
    }
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
        echo $sql;
        return;
        $this->pdo-exec($sql);
    }

}
?>