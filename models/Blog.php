<?php
namespace models;
class Blog extends Base{

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