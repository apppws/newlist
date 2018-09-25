<?php 
namespace controllers;
class TestController{
    public function email(){
        //Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.126.com', 25))
        ->setUsername('apppws@126.com')
        ->setPassword('pws5822193')
        ;
        // var_dump($transport);
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = new \Swift_Message();
        $message->setSubject('pws 测试邮箱')
                ->setFrom(['apppws@126.com' => '彭文双测试'])
                ->setTo(['danding@126.com', 'danding@126.com' => '你好'])
                ->setBody('<a>点击激活！</a>~~~~~~~~~~')
        ;

        $ret = $mailer->send($message);

        var_dump( $ret );
    }
}

?>