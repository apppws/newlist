<?php 
    namespace libs;
    class Email{
        public $mailer;
        public function __construct()
        {
            // 从配置文件中
            $config = config('email');
            //Create the Transport
            $transport = (new \Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['name'])
            ->setPassword($config['password'])
            ;
            // var_dump($transport);
            //创建邮箱的对象
            $this->mailer = new \Swift_Mailer($transport);
        }
        // 发送  $to ['邮箱地址']['姓名']
        public function send($title,$content,$to){
             // 从配置文件中读取配置
             $config = config('email');
             // 创建邮件消息
            $message = new \Swift_Message();
            $message->setSubject($title)
                    ->setFrom([$config['from_email'] =>$config['from_name']])
                    ->setTo([
                                $to[0],
                                $to[0] => $to[1]
                            ])
                    ->setBody($content,'text/html');  // 邮件的内容和邮件类型
            // 发送
          $res =  $this->mailer->send($message);
          var_dump($res);
        }
    }

?>