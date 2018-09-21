<?php
namespace models;
use PDO;
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

    // 静态页面
    public function contenthtml(){
        $stmt = self::$pdo->query("SELECT * FROM blogs");
        $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($blogs);
        // 开启缓存区
        ob_start();
        // 生成静态页面
        foreach($blogs as $v){
            // var_dump($v);s
            // 加载视图
            view('blog.comment',[
                'blog'=>$v
            ]);
            // 取出缓存区的内容
            $str = ob_get_contents();
            // 生成静态页面
            file_put_contents(ROOT."public/contents/".$v['id'].'.html',$str);
            // 清空缓冲区
            ob_clean();
        }
    }

    // 取20条数据
    public function indexhtml(){
        $stmt = self::$pdo->query("SELECT * FROM blogs WHERE is_show=1 ORDER BY id DESC LIMIT 10");
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 获取日志的浏览量
    public function getDisplay($id){
        // 1 设定redis key的值
        $key = "list_{$id}";
        // 连接redis
        $redis = new \Predis\Client([
            'scheme'=>'tcp',
            'host'=>'127.0.0.1',
            'port'=>'6379'
        ]);
        // 判断hash 是否有这个键  如果就操作内存 没有就从数据库中取数据
        if($redis->hexists('list_display',$key)){
            // 累加 并 返回添加后的值
            $newNum = $redis->hincrby('list_display',$key,1);
            // echo $newNum;
            return $newNum;
        }else{
            // 从库中取出浏览量
            $stmt = self::$pdo->prepare("SELECT display FROM WHERE id=?");
            $stmt->execute([
                $id
            ]);
            $display = $stmt->fetch(PDO::FETCH_COLUMN);
            $display++;
            // 保存到redis中
            $redis ->hset('list_display',$key,$display);
            return $display;
        }
        
    }

    // 把更新的浏览量更新到数据库中
    public function displayToDB(){
        // 在取出redis中保存的所有的数据
        $redis = new \Predis\Client([
            'scheme'=>'tcp',
            'host'=>'127.0.0.1',
            'port'=>'6379'
        ]);
        $data = $redis->hgetall('list_display');
        // var_dump($data);
        // 更新到数据库中
        foreach($data as $k=>$v){
            // echo $k;
            $id = str_replace('list_', '', $k);
            // echo $id;
            $sql = "UPDATE blogs SET display={$v} WHERE id={$id}";
            // var_dump($sql);
            self::$pdo->exec($sql);

        }
    }

 }


?>