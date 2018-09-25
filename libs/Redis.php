<?php
    namespace libs;
    class Redis{
        // 使用三私一公
        // 1 私有属性
        private static $redis = null;
        // 2 私有克隆方法
        private function __clone(){}
        // 3 私有构造方法
        private function  __construct(){}
        // 4 公有对开的方法
        public function getInstance(){
            // 判断如果还没有redis就new一个 
            if(self::$redis===null){
                // 放到队列中 
                self::$redis = new \Predis\Client([
                    'scheme'=>'tcp',
                    'host'=>'127.0.0.1',
                    'port'=>6379
                ]);  
            }
            // 如果有就直接调用
            return self::$redis;
        }
    }

?>