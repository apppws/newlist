<?php  
namespace controllers;
class UserController{

    // 处理注册页面
    public function doregister(){
        // 1.接收数据
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        // 2.调用模型
        $user = new \models\User;
        $red = $user->add($email,$password); 
        if(!$red){
            die('注册失败');
        }
        // 3 发邮件
        // $mail = new \libs\Email;
        // $message = "恭喜你注册成功";
        // // 从邮箱地址中取出姓名
        // $name = explode('@',$email);

          // 3. 保存到 Redis
            $redis = \libs\Redis::getInstance();
            // 序列化（数组转成 JSON 字符串）
            $value = json_encode([
                'email' => $email,
                'password' => $password,
            ]);
            // 键名
            $key = "temp_user:{$code}";
            // 保存到 Redis 中并设置过期时间 300 秒
            $redis->setex($key, 300, $value);
        // 构造收件人的地址
        $from = [$email,$name[0]]; 
        // var_dump($from);
        // 构造消息数组
        $message = [
            'title' => '彭文双邮箱测试',
            'content' => "点击以下链接进行激活：<br> <a href=''>点击激活</a>。",
            'from' => $from,
        ];
        // 把数组转字符串
        $message = json_encode($message);
        $redis  = \libs\redis::getInstance();
        $redis->lpush('email', $message);
        echo "ok";
        
    }
    // 注册页面
    public function register(){
        // 显示注册页面
        view('users.register');
    }
}