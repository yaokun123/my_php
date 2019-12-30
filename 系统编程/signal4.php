<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:20
 */


// 为 SIGINT 信号注册信号处理函数
pcntl_signal(SIGINT, function(){
    echo "捕获到了 SIGINT 信号" . PHP_EOL;
});



declare(ticks=1)
{
    $servsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_bind($servsock, '127.0.0.1', 8888);
    socket_listen($servsock, 1024);

    while(1)
    {
        $connsock = socket_accept($servsock); //如果没有客户端过来连接，这里将一直阻塞
        if ($connsock)
        {
            echo "客户端连接服务器: $connsock\n";
        }
    }
}


/**
 * 运行后代码一直阻塞在 socket_accept 函数这个地方等待客户端连接，这时的信号处理函数将无法被调用，
 * 直到某个客户端来连接：
 *
 *
 * 连按了五次 Ctrl + c ，信号函数都没有被调用，然后有一个客户端连接到了服务器，信号处理函数连续被调用了五次。
 * 作为对比，我这里用C写一个逻辑相同的程序来做对比，看看C语言里的信号处理是否有这种情况存在：
 */

//见signal.c文件


/**
 * 可以看到，同样是阻塞的状态，C中的信号函数仍旧能被正常调用，这也暴露了PHP中的信号触发机制是存在缺陷的，
 * 并且这种缺陷会让我们有时在处理信号时变的非常麻烦，尤其是代码中存在阻塞的情况，信号处理函数很可能不能被触发。
 * 后续说到守护进程时还会再提到这个问题。
 */