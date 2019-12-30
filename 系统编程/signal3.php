<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:10
 */

// 为 2号 信号注册信号处理函数(ctrl+c)
pcntl_signal(SIGINT, function(){
    echo "捕获到了 SIGINT 信号" . PHP_EOL;
});


declare(ticks = 1)
{
    $a = 0;
    while(1)
    {
        $a++;
        echo $a . PHP_EOL;
        sleep(1);
    }
}


/**
 * 这个程序会一直打印$a的值，当我们按下 Ctrl + c 时，就给程序发送了一个 SIGINT 信号，
 * 但由于我们自定义了信号处理，所以这时不会结束进程，而是打印一个字符串。
 *
 *
 * 这时我们可以用 Ctrl + \  （SIGQUIT）来结束程序
 */



/**
 * PHP中这种ticks 触发信号处理函数的机制导致了PHP在对信号处理时有很大的缺陷，
 * 如果PHP中有造成阻塞的语句，由于语句无法执行结束，无法触发tick事件，信号处理函数也就不会被回调。
 * 比如编写一个socket服务端程序：
 */

//见下一节