<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午10:17
 */


/**
 * 设置当前Worker实例所使用的传输层协议，目前只支持3种(tcp、udp、ssl)。不设置默认为tcp。
 *
 *
 */

use Workerman\Worker;
require_once  '../Workerman/Autoloader.php';

$worker = new Worker('text://0.0.0.0:8484');
// 使用udp协议
$worker->transport = 'udp';
$worker->onMessage = function($connection, $data)
{
    $connection->send('Hello');
};
// 运行worker
Worker::runAll();



// 证书最好是申请的证书
$context = array(
    'ssl' => array(
        'local_cert' => '/etc/nginx/conf.d/ssl/server.pem', // 也可以是crt文件
        'local_pk'   => '/etc/nginx/conf.d/ssl/server.key',
    )
);
// 这里设置的是websocket协议
$worker = new Worker('websocket://0.0.0.0:4431', $context);
// 设置transport开启ssl，websocket+ssl即wss
$worker->transport = 'ssl';
$worker->onMessage = function($con, $msg) {
    $con->send('ok');
};

Worker::runAll();


/**
 * 也没什么鸟用
 */