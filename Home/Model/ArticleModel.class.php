<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mr.wei
 * Date: 2019/3/24
 * Time: 16:08
 */
namespace Admin\Model;
use \Frame\Libs\BaseModel;
final class ArticleModel extends BaseModel
{
    protected $table = "article";
    public function  fetchWithJoin($where="2>1",$cur=0,$pageSize=10)
    {
        $sql = "select article.*,category.classname,user.name from `$this->table` ";
        //注意拼接 id 后留一个空格！！！
        $sql.="LEFT JOIN `category` on article.category_id=category.id ";
        $sql.="LEFT JOIN `user` on article.user_id=user.id ";
        $sql.= "WHERE {$where} ";
        $sql.="ORDER BY article.id DESC ";
        $sql.="limit $cur,$pageSize";
        return $this->pdo->fetchAll($sql);
    }
    public function Count($where)
    {
        $sql = "select count(*) From `$this->table` ";
        //注意拼接 id 后留一个空格！！！
        $sql.="LEFT JOIN `category` on article.category_id=category.id ";
        $sql.="LEFT JOIN `user` on article.user_id=user.id ";
        $sql.= "WHERE {$where} ";
        return $this->pdo->rowCount($sql);

    }
}