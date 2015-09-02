<?php
/**
 * Created by PhpStorm.
 * User: KDF5000
 * Date: 2015/9/2
 * Time: 10:58
 */

namespace Utils;

class ArgsUtil{

    /**
     * build mailder
     * @param $username
     * @param $password
     * @param string $server
     * @param int $port
     * @return mixed
     * @see \Monolog\Handler\SwiftMailerHandler
     */
    public static function buildSslMailer($username,$password,$server='smtp.163.com',$port=587){
        $transport = \Swift_SmtpTransport::newInstance($server, $port, 'ssl')
            ->setUsername($username)
            ->setPassword($password);
        $mailer = \Swift_Mailer::newInstance($transport);
        return $mailer;
    }

    /**
     * 消息模板
     * @param array $from
     * @param array $to
     * @return mixed
     * @see  \Monolog\Handler\SwiftMailerHandler
     */
    public static function buildMessageTp(array $from=array(),array $to = array()){
        $message = \Swift_Message::newInstance('Message Template')
                ->setFrom($from)
                ->setTo($to)
                ->setBody('Template');

        return $message;
    }

}