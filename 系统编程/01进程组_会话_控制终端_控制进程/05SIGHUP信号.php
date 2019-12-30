<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午11:07
 */

/**
 * 产生SIGHUP信号
 *
 *
 * 1、当一个会话失去控制终端时，内核会向该会话的控制进程发送一个 SIGHUP 信号，
 * 而通常会话的控制进程是shell进程，shell在收到一个 SIGHUP 信号时，
 * 会向由它创建的所有进程组（前台或后台进程组）也发送一个SIGHUP信号，然后退出，
 * 进程收到一个SIGHUP信号的默认处理方式就是退出进程，当然进程也可以自定义信号处理或者忽略它。
 *
 *
 * 2、另外，当控制进程终止时，内核也会向终端的前台进程组的所有成员发送SIGHUP信号。
 */


$callback = function($signo){
    $sigstr = 'unkown signal';
    switch($signo) {
        case SIGINT:
            $sigstr = 'SIGINT';
            break;
        case SIGHUP:
            $sigstr = 'SIGHUP';
            break;
        case SIGTSTP:
            $sigstr = 'SIGTSTP';
            break;
    }
    file_put_contents("/tmp/daemon.txt", "catch signal $sigstr\n", FILE_APPEND);
};


// 安装一个信号处理器
// 为signo指定的信号安装一个新 的信号处理器。
pcntl_signal(SIGINT, $callback);
pcntl_signal(SIGHUP, $callback);
pcntl_signal(SIGTSTP, $callback);



while(1)
{
    sleep(100);

    // 之前使用declare(ticks = 1) + pcntl_signal
    // PHP5.4以上版本就不再依赖ticks了，转而使用pcntl_signal_dispatch，在代码循环中自行处理信号。
    pcntl_signal_dispatch();
}



/**
 * 如果不自己处理SIGHUP信号的，进程会退出。
 * 运行起该程序，然后直接关掉终端，重新登录shell，会发现该程序仍在运行，daemon.txt 文件中会 记录捕获到的SIGHUP信号。
 */



/**
 * 同时linux下提供了一个nohup命令，可以让进程忽略所有的SIGHUP信号
 */
