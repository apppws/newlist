<?php
    namespace controllers;
    class BlogController{

        // 显示日志列表的功能
        public function list(){
            // 3.搜索功能
            $where = 1;
            // 3.1 接收keyword的值  并且不为空的
            if(isset($_GET['keywords']) && $_GET['keywords']){
                $where.=" AND (title like '%{$_GET['keywords']}%' OR content like '%{$_GET['keywords']}%')";
            }
            // var_dump($where);
            // 3.2 发表日期 
            if(isset($_GET['start_date']) && $_GET['start_date']){
                 $where.= " AND created_at >= '{$_GET['start_date']}'";
            }
            // 3.3  更新时间
            if(isset($_GET['end_date']) && $_GET['end_date']){
                $where.= " AND updated_at <= '{$_GET['end_date']}'";
             }
            //  3.4 是否显示 
            if(isset($_GET['is_show']) && $_GET['is_show']){
               $where.=" AND is_show ={$_GET['is_show']}";
            }
            /***********************************/ 
            // 4 排序功能
            // 4.1 默认的排序的方式
            $orderBy = 'created_at';
            $orderyway = 'desc'; 
            // 4.2设置排序字段
            if(isset($_GET['order_by']) && $_GET['order_by']=='display'){
                $orderBy = 'display';
            }
            // 4.3 设置排序方式
            if(isset($_GET['order_way']) && $_GET['order_way']=='asc'){
                $orderyway = 'asc';

            }

            /************************************/
            // 1 调用模型 
            $blog = new \models\Blog;
            $blogs = $blog->getlist($where,$orderBy,$orderyway);
            // var_dump($blogs);
            view('blog.list',[
                'blog' =>$blogs
            ]);
        }

        // 处理发日志
        public function dosendlist(){
            // 1 接收数据 
            $title = $_POST['title'];
            $content = $_POST['content'];
            $is_show = $_POST['is_show'];
            // 2 调用模型 插入数据库中
            $blog = new \models\Blog;
            $blog->dosendlists($title,$content,$is_show);
          
        }
        
        // 发日志的显示
        public function sendlist(){
            view('blog.sendlist');
        }

        // 模拟数据
        public function mock(){
            $user =  new \models\Blog;
            for($i=0;$i<100;$i++){
                $user->exec('TRUNCATE TABLE blogs');
                // 循环100条
                for($i = 0;$i<100;$i++){
                    $user->insert([
                        'title' => $this->getchar(10,100),
                        'content' => $this->getChar(100,300),
                        'display'=>rand(5,1000),
                        'is_show'=>rand(0,1),
                        'created_at' =>date('Y-m-d H:i:s',rand(1000000000,1543233112)),
                        'updated_at' =>date('Y-m-d H:i:s',rand(1000000000,1543233112)),
                    ]);
                    
                }
                echo "成功！";  
            }
        }
    
        // 生成随机的汉字
        function getChar($num)  // $num为生成汉字的数量
        {
        $b = '';
        for ($i=0; $i<$num; $i++) {
            // 使用chr()函数拼接双字节汉字，前一个chr()为高位字节，后一个为低位字节
            $a = chr(mt_rand(0xB0,0xD0)).chr(mt_rand(0xA1, 0xF0));
            // 转码
            $b .= iconv('GB2312', 'UTF-8', $a);
        }
        return $b;
        }

    }



?>