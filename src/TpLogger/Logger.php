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
use ReflectionClass;

class Logger{

    const DEFAULT_HANLDER = 'StreamHandler'; //默认的handler
    const DEFAULT_PATH = 'default_log';  //默认的log文件

    const DEBUG = MonoLogger::DEBUG;
    const INFO = MonoLogger::INFO;
    const NOTICE = MonoLogger::NOTICE;
    const WARNING = MonoLogger::WARNING;
    const ERROR = MonoLogger::ERROR;
    const CRITICAL = MonoLogger::CRITICAL;
    const ALERT = MonoLogger::ALERT;
    const EMERGENCY = MonoLogger::EMERGENCY;

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
            //通过设置自动配置
            foreach($config as $key => $val){
                $class = new ReflectionClass('Monolog\\Handler\\'.$key);
                $handler = $class->newInstanceArgs(array_values($val));
                self::$logger->pushHandler($handler);
            }
        }
    }

    /**
     *调用Monolog/Logger的方法
     * @param $name
     * @param $params
     */
    public static function __callStatic($name, $params){
        $class = new ReflectionClass(self::$logger);
        if($class->hasMethod($name)){
            self::$logger->$name($params[0],$params[1]);
        }else{
            throw new \BadMethodCallException;
        }
    }
}