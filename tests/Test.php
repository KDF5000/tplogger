<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 2015/9/1
 * Time: 15:40
 */

require '../vendor/autoload.php';

use TpLogger\Logger;

$logger = new Logger();
$logger->init(array(
    "StreamHandler" => array(
        'filename' => 'my_log_stream.log',
        'level' => Logger::DEBUG,
    ),
    "RotatingFileHandler" => array(
        'filename' => 'my_log_rotating.log',
        'maxfiles' => 0,
        'level' => Logger::ERROR,
    ),
));
//$logger->addDebug('hello');
$logger::addError('i am an error', array("lines"));
$logger::addWarning('i am an error', array("lines"));
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
//
//$logger = new Logger('test');
//$logger->pushHandler(new StreamHandler('demo.txt'), Logger::DEBUG);
//
//$logger->addDebug('nihao');
