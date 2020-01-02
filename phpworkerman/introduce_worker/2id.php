<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午9:51
 */


/**
 * 当前worker进程的id编号，范围为0到$worker->count-1。
 *
 *
 * 这个属性对于区分worker进程非常有用，例如1个worker实例有多个进程，开发者只想在其中一个进程中设置定时器，
 * 则可以通过识别进程编号id来做到这一点，比如只在该worker实例id编号为0的进程设置定时器（见范例）。
 */


/**
 * 注意：
 * 进程重启后id编号值是不变的。
 * 进程编号id的分配是基于每个worker实例的。每个worker实例都从0开始给自己的进程编号，
 * 所以worker实例间进程编号会有重复，但是一个worker实例中的进程编号不会重复。例如下面的例子：
 */


use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

// worker实例1有4个进程，进程id编号将分别为0、1、2、3
$worker1 = new Worker('tcp://0.0.0.0:8585');
// 设置启动4个进程
$worker1->count = 4;
// 每个进程启动后打印当前进程id编号即 $worker1->id
$worker1->onWorkerStart = function($worker1)
{
    echo "worker1->id={$worker1->id}\n";
};



// worker实例2有两个进程，进程id编号将分别为0、1
$worker2 = new Worker('tcp://0.0.0.0:8686');
// 设置启动2个进程
$worker2->count = 2;
// 每个进程启动后打印当前进程id编号即 $worker2->id
$worker2->onWorkerStart = function($worker2)
{
    echo "worker2->id={$worker2->id}\n";
};

// 运行worker
Worker::runAll();



/**
 * 输出类似：
worker1->id=0
worker1->id=1
worker1->id=2
worker1->id=3
worker2->id=0
worker2->id=1
 */



/**
 * 注意：windows系统由于不支持进程数count的设置，只有id只有一个0号。
 * windows系统下不支持同一个文件初始化两个Worker监听，所以windows系统这个示例无法运行。
 */



/**
 * 一个worker实例有4个进程，只在id编号为0的进程上设置定时器。
 *
 */
//use Workerman\Lib\Timer;
//$worker = new Worker('tcp://0.0.0.0:8585');
//$worker->count = 4;
//$worker->onWorkerStart = function($worker)
//{
    // 只在id编号为0的进程上设置定时器，其它1、2、3号进程不设置定时器
//    if($worker->id === 0)
//    {
//        Timer::add(1, function(){
//            echo "4个worker进程，只在0号进程设置定时器\n";
//        });
//    }
//};
// 运行worker
//Worker::runAll();