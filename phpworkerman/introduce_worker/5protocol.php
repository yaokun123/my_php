<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午10:12
 */


/**
 * 设置当前Worker实例的协议类。
 *
 *
 * 注：协议处理类可以直接在初始化Worker在监听参数时直接指定。例如
 *
 * $worker = new Worker('http://0.0.0.0:8686');
 */


use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$worker = new Worker('tcp://0.0.0.0:8686');
$worker->protocol = 'Workerman\\Protocols\\Http';

$worker->onMessage = function($connection, $data)
{
    var_dump($_GET, $_POST);
    $connection->send("hello");
};

// 运行worker
Worker::runAll();



/**
 * 以上代码等价于下面代码
 */



/**
 * 首先会查看用户是否有自定义\Protocols\Http协议类，
 * 如果没有使用workerman内置协议类Workerman\Protocols\Http
 */
$worker = new Worker('http://0.0.0.0:8686');

$worker->onMessage = function($connection, $data)
{
    var_dump($_GET, $_POST);
    $connection->send("hello");
};

// 运行worker
Worker::runAll();



/**
 * 总结：没什么鸟用
 */