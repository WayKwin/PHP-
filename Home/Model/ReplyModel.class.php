<?php
 namespace Home\Model;
 use \Frame\Libs\BaseModel;
 final class ReplyModel extends BaseModel
 {
     protected $table = "reply";
     public function  deleteReply($id)
     {
         $sql = "DELETE FROM $this->table WHERE id = $id";
         return $this->pdo->exec($sql);
     }
 }
