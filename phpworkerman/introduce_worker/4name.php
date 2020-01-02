<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午10:11
 */



/**
 * 设置当前Worker实例的名称，方便运行status命令时识别进程。不设置时默认为none。
 *
 *
 * 范例
 */


use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$worker = new Worker('websocket://0.0.0.0:8484');



// 设置实例的名称
$worker->name = 'MyWebsocketWorker';




$worker->onWorkerStart = function($worker)
{
    echo "Worker starting...\n";
};
// 运行worker
Worker::runAll();