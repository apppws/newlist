<?php
namespace models;
class Blog extends Base{
    public $tableName = 'blogs';
    // 
    // 取全部日志
    public function getlist($where,$orderBy,$orderyway,$limit){
        $stmt = self::$pdo->query("SELECT * FROM blogs WHERE $where ORDER BY $orderBy $orderyway LIMIT $limit");
        return $stmt->fetchAll();
    }
    // 发日志
    public function dosendlists($title,$content,$is_show){
        // 预处理
        $stmt = self::$pdo->prepare("INSERT INTO blogs(title,content,is_show) VALUES(?,?,?)");
        // 执行
        $stmt->execute([
            $title,
            $content,
            $is_show
        ]);
    }

    // 修改数据
    public function updates($title,$content,$is_show,$id){
        $stmt = self::$pdo->prepare("UPDATE blogs SET title=?,content=?,is_show=? where id=? ");
        // var_dump($stmt);
        $stmt->execute([
            $title,
            $content,
            $is_show,
            $id
        ]);
    }

    // 删除
    public function deletes($id){
        $stmt = self::$pdo->prepare("DELETE FROM blogs WHERE id=?");
        $stmt->execute([$id]);
    }

     // 查询
     public function find($id){
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->tableName} WHERE id=?");
        $stmt->execute([
            $id
        ]);
        return $stmt->fetch();
    }

 }


?>