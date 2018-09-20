<?php
namespace models;
class Blog extends Base{
    public $tableName = 'blogs';
    // 取全部日志
    public function getlist($where,$orderBy,$orderyway){
        $stmt = self::$pdo->query("SELECT * FROM blogs WHERE $where ORDER BY $orderBy $orderyway");
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

}


?>