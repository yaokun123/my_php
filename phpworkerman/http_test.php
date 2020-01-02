<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/8
 * Time: 下午4:36
 */


//使用HTTP协议对外提供web服务


use Workerman\Worker;
require_once __DIR__.'/Workerman/Autoloader.php';


//创建一个Worker监听2345端口，使用http协议通信
$http_worker = new Worker("http://0.0.0.0:2345");


//启动4个进程对外提供服务
$http_worker->count = 4;


//接受到浏览器发送的数据时回复hello world给浏览器
$http_worker->onMessage = function($connection,$data){
    //向浏览器发送hello world
    $connection->send('hello world');
};


//运行worker
Worker::runAll();


/**
 * 命令行运行：php http_test.php start
 *
 * 在浏览器中访问url http://127.0.0.1:2345
 */