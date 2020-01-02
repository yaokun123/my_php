<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午10:35
 */


/**
 * 设置当前Worker实例以哪个用户运行。此属性只有当前用户为root时才能生效。不设置时默认以当前用户运行。
 *
 * 建议$user设置权限较低的用户，例如www-data、apache、nobody等。
 *
 * 注意：此属性必须在Worker::runAll();运行前设置才有效。windows系统不支持此特性。
 */



use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$worker = new Worker('websocket://0.0.0.0:8484');




// 设置实例的运行用户
$worker->user = 'www-data';




$worker->onWorkerStart = function($worker)
{
    echo "Worker starting...\n";
};
// 运行worker
Worker::runAll();