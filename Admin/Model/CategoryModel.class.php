<?php
namespace Admin\Model;
use \Frame\Libs\BaseModel;
final class CategoryModel extends BaseModel
{
    protected $table = "category";
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
        //该分类下没有子分类，可以删除了
        $this->delete('id',$aimId);
    }

}
?>

