<?php 
    
namespace models;
use PDO;
class Base{
    // 连接数据库
    public static $pdo = null;   //创建一个空的对象
    private $host = "127.0.0.1";   //本机的IP地址
    private $dbname = "mvclist";  //数据库
    private $root = "root";   //用户名
    private $password = "";   //密码
    // 创建一个构造方法
    public function __construct()
    {
        if(self::$pdo==null){
            // 就生成 pdo对象
            self::$pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->root,$this->password);
            self::$pdo->exec("set names utf8");
        }
    }



}




?>