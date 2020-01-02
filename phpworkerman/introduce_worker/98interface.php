<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/9
 * Time: 下午10:08
 */



/**
 *
 * 1、runAll
 *
 *
 * 运行所有Worker实例。
 *
 * Worker::runAll()执行后将永久阻塞，也就是说位于Worker::runAll()后面的代码将不会被执行。
 * 所有Worker实例化应该都在Worker::runAll()前进行。
 *
 * 无参数、无返回值
 */



//范例 运行多个Worker实例

use Workerman\Worker;
require_once  '../Workerman/Autoloader.php';

$http_worker = new Worker("http://0.0.0.0:2345");
$http_worker->onMessage = function($connection, $data)
{
    $connection->send('hello http');
};

$ws_worker = new Worker('websocket://0.0.0.0:4567');
$ws_worker->onMessage = function($connection, $data)
{
    $connection->send('hello websocket');
};

// 运行所有Worker实例
Worker::runAll();



/**
 * 2、stopAll
 *
 * 停止当前进程（子进程）的所有Worker实例并退出。
 *
 * 此方法用于安全退出当前子进程，作用相当于调用exit/die退出当前子进程。
 *
 * 与直接调用exit/die区别是，直接调用exit或者die无法触发onWorkerStop回调，
 * 并且会导致一条WORKER EXIT UNEXPECTED错误日志。
 *
 *
 * 无参数、无返回值
 */


/**
 * 下面例子子进程每处理完1000个请求后执行stopAll退出，以便重新启动一个全新进程。
 * 类似php-fpm的max_request属性，主要用于解决php业务代码bug引起的内存泄露问题。
 */

// 每个进程最多执行1000个请求
define('MAX_REQUEST', 1000);

$http_worker = new Worker("http://0.0.0.0:2345");
$http_worker->onMessage = function($connection, $data)
{
    // 已经处理请求数
    static $request_count = 0;

    $connection->send('hello http');
    // 如果请求数达到1000
    if(++$request_count >= MAX_REQUEST)
    {
        /*
         * 退出当前进程，主进程会立刻重新启动一个全新进程补充上来
         * 从而完成进程重启
         */
        Worker::stopAll();
    }
};


/**
 * 3、listen
 *
 * 用于实例化Worker后执行监听。
 *
 * 此方法主要用于在Worker进程启动后动态创建新的Worker实例，能够实现同一个进程监听多个端口，支持多种协议。
 * 需要注意的是用这种方法只是在当前进程增加监听，并不会动态创建新的进程，也不会触发onWorkerStart方法。
 *
 * 例如一个http Worker启动后实例化一个websocket Worker，那么这个进程即能通过http协议访问，
 * 又能通过websocket协议访问。由于websocket Worker和http Worker在同一个进程中，
 * 所以它们可以访问共同的内存变量，共享所有socket连接。
 * 可以做到接收http请求，然后操作websocket客户端完成向客户端推送数据类似的效果
 */