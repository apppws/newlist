<?php 
    // 1.主入口文件  设置一个常量 
    define('ROOT', dirname(__FILE__) . '/../');
    // 2.类的自动加载
     spl_autoload_register('autoload');
     // 第二步实现自动加载
        function autoload($class)
        {
                //  var_dump($class);
                // 引入文件 并拼接  形成搜索
                $path = str_replace('\\', '/', $class);
                // var_dump();
                // var_dump(ROOT .'\\'. $path . '.php');
                require(ROOT .'\\'. $path . '.php');
        }

    //3.加载视图函数实现
    function view($file,$data=[]){
        // 判断如果传了数据，就把数组展开成变量
        if($data) extract($data);
        // 加载视图
        require ROOT . 'views/' . str_replace('.','/', $file) . '.html';

    }
    //     echo '<pre>';
    // var_dump($_SERVER);
    // 4.路由解析
    function route(){
        // 解析路由的原因 就是 控制器/方法
        // 获取URL   判断地址栏是否有这个参数  有就获取没有就默认为/  
        $url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "/";
        // 定义默认的控制器和方法
        $defaultController = "IndexController";
        $defaultAction = "index";
        // 判断
        if($url=='/'){
            //如果这个地址等于/  就返回默控制器和方法
            return [
                $defaultController,
                $defaultAction
            ];
            // strpos 判断这个字符串是否有这个字符
        }else if(strpos($url,'/',1)!==FALSE){
            //如果这个有控制器和方法就取出来
            // 1.去掉 /
            $url = ltrim($url,'/');
            // 2 取出控制器和方法
            $route = explode('/',$url);
            // 3.格式化控制器名
            $route[0] = ucfirst($route[0])."Controller";
            // 4 返回
            return $route;
        }else{
            die("请求的URL 格式不正确 ");
        }
    }
    $route = route();
    // var_dump($route) ;

    // 5.任务分发
    $controller = "controllers\\{$route[0]}";   //控制器
    $action = $route[1];     //方法
    // 创建控制对象
    $c= new $controller;
    $c->$action();

    // 6.获取get参数
    function getUrlParams($except = []){
        $ret = '';
        // 从 $_GET 中删除要排除的参数
        foreach($except as $v)
        {
            unset($_GET[$v]);
        }

        foreach($_GET as $k => $v)
        {
            $ret .= "&$k=$v";
        }

        return $ret;
    }
    // 

?>