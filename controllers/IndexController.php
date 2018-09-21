<?php  
 namespace controllers;
 class IndexController{
    //  生成首页
    public function index(){
        // 调用日志20条
        $model = new \models\Blog;
        $data = $model->indexhtml();
        // var_dump($data);
        // 显示
        view('index.index',[
            'data'=>$data
        ]);
    }
 }