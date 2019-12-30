<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:34
 */


/**
 * posix_kill 可以在代码中向指定程序发送信号
 *
 * bool posix_kill ( int $pid , int $sig )
 *
 *
 * 比如在程序中向自己发送信号
 */


pcntl_signal(SIGINT, function(){//ctrl+c
    echo "捕获到 SIGINT 信号\n";
    posix_kill(posix_getpid(), SIGQUIT);  //向自己发送 SIGQUIT 信号
});


pcntl_signal(SIGQUIT, function(){//ctrl+\
    echo "catch signal SIGQUIT \n";
});


declare(ticks = 1)
{
    while(1)
    {
        sleep(1);
    }
}


//不过现在想要结束程序，需要使用 kill -9 了。

