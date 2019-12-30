<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/4
 * Time: 下午5:18
 */

/**
 * pcntl_wait函数挂起当前进程的执行，直到一个子进程退出或接收到一个信号要求中断当前进程或调用一个信号处理函数。
 * 如果一个子进程在调用此函数时已经退出（俗称僵尸进程），此函数立刻返回。子进程使用的所有系统资源将被释放。
 *
 */


$ppid = posix_getpid();//记录父进程的进程号

for($i=0;$i<5;$i++){
    $pid = pcntl_fork();


    if ($pid == 0)
    {
        break; //由于子进程也会执行循环的代码，所以让子进程退出循环
    }
}



if ($ppid == posix_getpid())
{
    //父进程循环回收收子进程
    while(($id = pcntl_wait($status)) > 0) //如果没有子进程退出, pcntl_wait 会一直阻塞
    {
        echo "回收子进程：$id, 子进程退出状态值: $status...\n";
    }

    exit("父进程退出 $id....\n"); //当子进程全部结束 pcntl_wait 返回-1
}
else
{
    //子进程退出,会成为僵尸进程
    sleep($i);
    exit($i);
}