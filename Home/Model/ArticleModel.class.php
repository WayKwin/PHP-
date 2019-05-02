<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mr.wei
 * Date: 2019/3/24
 * Time: 16:08
 */
namespace Home\Model;
use \Frame\Libs\BaseModel;
final class ArticleModel extends BaseModel
{
    protected $table = "article";
    protected $replyTable = "reply";
    //获取所有文章
    public function  fetchWithJoin($where="2>1",$cur=0,$pageSize=10,$orderBy="article.addate DESC")
    {
        $sql = "select article.*,category.classname,user.name as username,user_info.* from `$this->table` ";
        //注意拼接 id 后留一个空格！！！
        $sql.="LEFT JOIN `category` on article.category_id=category.id ";
        $sql.="LEFT JOIN `user` on article.user_id=user.id ";
        $sql.="LEFT JOIN `user_info` on article.user_id=user_info.user_id ";
        $sql.= "WHERE {$where} ";
        $sql.="ORDER BY {$orderBy} ";
        $sql.="limit $cur,$pageSize ";
        return $this->pdo->fetchAll($sql);
    }
    //通过Id获取一个文章
    public function fetchOneWithJoin($id)
    {
        $sql = "select article.*,category.classname,user.name as username,user_info.* from `$this->table` ";
        //注意拼接 id 后留一个空格！！！
        $sql.="LEFT JOIN `category` on article.category_id=category.id ";
        $sql.="LEFT JOIN `user` on article.user_id=user.id ";
        $sql.="LEFT JOIN `user_info` on article.user_id=user_info.user_id ";
        $sql.= "WHERE article.id=$id ";
        return $this->pdo->fetchOne($sql);
    }
     public function addReadCount($id)
    {
        $sql = "UPDATE $this->table set read_count=read_count+1 WHERE id=$id";
        return $this->pdo->exec($sql);
    }
    public function addReplyCount($id)
    {
        $sql = "UPDATE $this->table set comment_count=comment_count+1 WHERE id=$id";
        return $this->pdo->exec($sql);
    }
    public function addArticleMaxFloor($id)
    {
        $sql = "UPDATE $this->table set max_floor=max_floor+1 WHERE id=$id";
        return $this->pdo->exec($sql);
    }

    public function deleteReplyCount($id)
    {
        $sql = "UPDATE $this->table set comment_count=comment_count-1 WHERE id=$id";
        return $this->pdo->exec($sql);

    }
    //获取该文章所有的回复
    public function fetchAllReply($article_id,$cur=0,$pageSize=10,$orderBy="reply.addate")
    {
        $sql = "select reply.*,user.name as username,user_info.* from `$this->replyTable` ";
        //注意拼接 id 后留一个空格！！！
        $sql.="LEFT JOIN `article` on article.id=reply.article_id ";
        $sql.="LEFT JOIN `user` on   reply.user_id=user.id ";
        $sql.="LEFT JOIN `user_info` on reply.user_id=user_info.user_id ";
        $sql.= "WHERE  reply.article_id={$article_id} ";
        $sql.="ORDER BY {$orderBy} ";
        $sql.="limit $cur,$pageSize ";
        return $this->pdo->fetchAll($sql);
    }

    //多少篇文章
    public function Count($where="2>1")
    {
        $sql = "select count(*) From `$this->table` ";
        //注意拼接 id 后留一个空格！！！
        $sql.="LEFT JOIN `category` on article.category_id=category.id ";
        $sql.="LEFT JOIN `user` on article.user_id=user.id ";
        $sql.= "WHERE {$where} ";
        return $this->pdo->rowCount($sql);
    }
}