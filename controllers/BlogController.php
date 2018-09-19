<?php
    namespace controllers;
    class BlogController{

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