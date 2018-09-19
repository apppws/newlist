<?php
    namespace controllers;
    class BlogController{

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
        
        // 显示日志列表的功能
        public function list(){
            // 1 调用模型 
            $blog = new \models\Blog;
            $blogs = $blog->getlist();
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

    }



?>