<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/4
 * Time: 下午4:41
 */

/**
 * 代码演示僵尸进程的产生：
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
    //父进程不退出，也不回收子进程
    while(1)
    {
        sleep(1);
    }
}
else
{
    //子进程退出,会成为僵尸进程
    exit("子进程退出 $ppid ...\n");
}


/**
 * 运行之后查看进程状态：
 * [root@localhost ~]# ps -ef | grep php
root      2971  2864  0 14:13 pts/0    00:00:00 php pcntl.fork.php
root      2972  2971  0 14:13 pts/0    00:00:00 [php] <defunct>
root      2973  2971  0 14:13 pts/0    00:00:00 [php] <defunct>
root      2974  2971  0 14:13 pts/0    00:00:00 [php] <defunct>
root      2975  2971  0 14:13 pts/0    00:00:00 [php] <defunct>
root      2976  2971  0 14:13 pts/0    00:00:00 [php] <defunct>
root      2978  2912  0 14:13 pts/1    00:00:00 grep php
 */



/**
 * 僵尸进程会用 <defunct>（死者，死人） 来标识，除非我们结束父进程，否则这些僵尸进程会一直存在，
 * 也无法用kill命令来杀死。
 *
 * PHP的pcntl扩展提供了两个回收子进程的方法供我们调用：
 * int pcntl_wait ( int &$status [, int $options = 0 ] )
 * int pcntl_waitpid ( int $pid , int &$status [, int $options = 0 ] )
 */



/**
 * pcntl_wait函数挂起当前进程的执行，直到一个子进程退出或接收到一个信号要求中断当前进程或调用一个信号处理函数。
 * 如果一个子进程在调用此函数时已经退出（俗称僵尸进程），此函数立刻返回。子进程使用的所有系统资源将被释放。
 *
 */


//见下一节