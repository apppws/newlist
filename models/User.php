<?php
    namespace models;
    use PDO;
    class User extends Base {
        // 注册时添加数据
        public function add($email,$password){
            $stmt = self::$pdo->prepare("INSERT INTO users(email,password) VALUES(?,?)");
            return $stmt->execute([
                $email,
                $password
            ]);
        }
        
    }


?>