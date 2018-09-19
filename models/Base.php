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
    // 插入数据
     public function insert($data)
        {
            // 拼 SQL 语句
            $keys = array_keys($data);     // 取出数组中的键，构造新数组
            $values = array_values($data);   // 取出数组中的值，构造新数组

            // 拼出键的字符串，格式为： xxx,xxx,xxx,xxx,xxx
            $keyString = implode(',', $keys);

            // 拼出值的字符串，格式为：xxx','xxx','xxx
            $valueString = implode("','", $values);

            // 拼出 insert 语句，格式为 insert into 表名(字段,字段...) values('值','值'...)
            $sql = "INSERT INTO {$this->tableName} ($keyString) VALUES('$valueString')";

            // 执行SQL
            $this->exec($sql);

            // 返回新插入记录的ID
            return self::$pdo->lastInsertId();
        }
        // 执行的
        public function exec($sql){
                $ret = self::$pdo->exec($sql);
                if($ret === false)
                {
                    echo $sql , '<hr>';
                    $error = self::$pdo->errorInfo();
                    die($error[2]);
                }
                return $ret;
            }



}




?>