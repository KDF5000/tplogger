<?php
/**
 * Created by PhpStorm.
 * User: KDF5000
 * Date: 2015/9/1
 * Time: 15:18
 */

namespace TpLogger;
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

use Monolog\Handler\HandlerInterface;
use ReflectionClass;

class Logger{

    const DEFAULT_HANLDER = 'StreamHandler'; //Ĭ�ϵ�Handler
    const DEFAULT_PATH = 'my_log.log';  //Ĭ��log�洢�ļ�

    const DEBUG = MonoLogger::DEBUG;
    const INFO = MonoLogger::INFO;
    const NOTICE = MonoLogger::NOTICE;
    const WARNING = MonoLogger::WARNING;
    const ERROR = MonoLogger::ERROR;
    const CRITICAL = MonoLogger::CRITICAL;
    const ALERT = MonoLogger::ALERT;
    const EMERGENCY = MonoLogger::EMERGENCY;

    /**
     * @var HandlerInterface
     */
    static private $handler;
    /**
     * @var \Monolog\Logger
     */
    static protected $logger = null;

    /**
     * @param array $config
     * @param string $logName
     * example:
     * @see \Monolog\Handler
     * array = array(
     *     "StreamHandler" => array(
     *            'filename' => 'my_log.log',
     *            'level' => Logger::Debug,
     *
     *     ),
     *     "RotatingFileHandler" => array(
     *            'filename' => 'webapp_log',
     *            'max_file' => 0,
     *            'level' => Logger::Debug,
     *     ),
     *     "SwiftMailerHander" => array(
     *            'level' => Logger::Debug,
     *            'mailer'=> SwiftMailer,
     *     )
     *     ...
     * )
     */
    public static function init(array $config=array(),$logName='my_log'){
        if(self::$logger == null){
            self::$logger = new MonoLogger($logName);
        }
        if(empty($config)){
            self::$logger->pushHandler(new StreamHandler(self::DEFAULT_PATH, self::DEBUG));
        }else{
            //ͨ�������Զ�����
            foreach($config as $key => $val){
                $class = new ReflectionClass('Monolog\\Handler\\'.$key);
                $handler = $class->newInstanceArgs(array_values($val));
                self::$logger->pushHandler($handler);
            }
        }
    }

    /**
     * @param $message
     */
    public static function addDebug($message){
        self::$logger->addDebug($message);
    }

    /**
     * @param $message
     */
    public static function addError($message){
        self::$logger->addError($message);
    }

}