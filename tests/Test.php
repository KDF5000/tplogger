<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 2015/9/1
 * Time: 15:40
 */

require '../vendor/autoload.php';

use TpLogger\Logger;
use Utils\ArgsUtil;

class TestLogger extends PHPUnit_Framework_TestCase{

    private $config = array(
        "StreamHandler" => array(
            'log_path' => 'my_log_stream.log',
            'level' => Logger::DEBUG,
        ),
        "RotatingFileHandler" => array(
            'log_path' => 'my_log_rotating.log',
            'maxfiles' => 0,
            'level' => Logger::ERROR,
        ),
    );

    public function testLogger(){
        Logger::init($this->config);
        Logger::addDebug('i am a debug', array("name"=>'kdf','age'=>23));
        Logger::addError('i am an error', array("lines"));
    }


    public function testMailHandler(){
//        $transport = Swift_SmtpTransport::newInstance('smtp.163.com', 587, 'ssl')
//            ->setUsername('zhongguohaolaoban@163.com')
//            ->setPassword('sqjeobpiththsgdh');
//        $mailer = Swift_Mailer::newInstance($transport);
//
////        // Create a message
//        $message = Swift_Message::newInstance('Wonderful Subject')
//            ->setFrom(array('zhongguohaolaoban@163.com' => 'Boss'))
//            ->setTo(array('kdf5000@163.com', '1781022885@qq.com' => 'A name'))
//            ->setBody('测试邮件');
//
//        // Send the message
//        $result = $mailer->send($message);
//        echo $result;
        $mailer = ArgsUtil::buildSslMailer('zhongguohaolaoban@163.com','sqjeobpiththsgdh');
        $message = ArgsUtil::buildMessageTp(array('zhongguohaolaoban@163.com' => '好老板'),array('kdf5000@163.com'));
        Logger::init(array(
            'SwiftMailerHandler'=>array(
                'mailer'=>$mailer,
                'message'=>$message
            )
        ));

        Logger::addError('mailer error');

    }


}