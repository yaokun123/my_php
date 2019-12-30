<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:54
 */

while(1)
{
    //进入循环时 屏蔽信号(ctrl+c、ctrl+\、)
    pcntl_sigprocmask(SIG_BLOCK, array(SIGINT, SIGQUIT, SIGTERM), $oldset);

    /* 假设下面这段代码必需要完整执行 */

    echo "----------------------start-----------------------\n";
    echo "11111111\n";
    sleep(1);

    echo "22222222222\n";
    sleep(1);

    echo "33333333\n";
    sleep(1);
    echo "-------------------------end-----------------------\n";


    //代码块执行完解除信号屏蔽
    pcntl_sigprocmask(SIG_UNBLOCK, array(SIGINT, SIGQUIT, SIGTERM), $oldset);
}

/**
 * 这样就可以确保无论什么时候向进程发送信号，这个代码块总能执行完程序才会退出
 *
 *
 *
 * 后面说到守护进程时，为了确保子进程把任务执行完才退出，我们也会用到这个技术。
 */