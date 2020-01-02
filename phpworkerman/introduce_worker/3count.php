<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午10:05
 */


/**
 * 设置当前Worker实例启动多少个进程，不设置时默认为1。
 * 注意：此属性必须在Worker::runAll();运行前设置才有效。windows系统不支持此特性。
 *
 * 范例
 */


use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$worker = new Worker('websocket://0.0.0.0:8484');
// 启动8个进程，同时监听8484端口，以websocket协议提供服务
$worker->count = 8;
$worker->onWorkerStart = function($worker)
{
    echo "Worker starting...\n";
};
// 运行worker
Worker::runAll();