<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午11:23
 */

/**
 * 编写守护进程涉及的其他问题
 *
 *
 * 编写守护进程还涉及工作目录、文件掩码、信号处理、热更新、安全的启动停止等等问题，这里先留给大家自己百度，后期有空再来补充。
 */



/**
 * 一个守护进程的示例
 */


//由于进程组长无法创建会话，fork一个子进程并让父进程退出，以便可以创建新会话
switch(pcntl_fork()) {
    case -1:
        exit("fork error");
        break;
    case 0:
        break;
    default:
        exit(0); //父进程退出
}

posix_setsid();  //创建新会话,脱离原来的控制终端

//再次fork并让父进程退出, 子进程不再是会话首进程，让其永远无法打开一个控制终端
switch(pcntl_fork()) {
    case -1:
        exit("fork error");
        break;
    case 0:
        break;
    default:
        exit(0); //父进程退出
}

//关闭标准输入输出
fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
fopen('/dev/null', 'r');
fopen('/dev/null', 'w');
fopen('/dev/null', 'w');

//切换工作目录
chdir('/');

//清除文件掩码
umask(0);

//由于内核不会再为进程产生SIGHUP信号，我们可以使用该信号来实现热重启
pcntl_signal(SIGHUP, function($signo){
    //重新加载配置文件，重新打开日志文件等等
});

for(;;)
{
    pcntl_signal_dispatch();  //处理信号回调
    //实现业务逻辑
}
