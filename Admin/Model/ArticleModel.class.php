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
    public function  fetchWithJoin()
    {
       $sql = "select article.*,category.classname,user.name from `$this->table`";
                           //注意拼接 id 后留一个空格！！！
       $sql.="left join `category` on article.category_id=category.id ";
       $sql.="left join `user` on article.user_id=user.id ";
       $sql.="ORDER BY article.id DESC";
       return $this->pdo->fetchAll($sql);
    }
}

