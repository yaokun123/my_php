<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/4
 * Time: 下午3:22
 */

/**
 * 多进程编程也是系统编程的一个重要方面，但PHP程序员通常不需要关心多进程的问题，
 * 因为web服务器或者PHP-FPM已经帮我们管理好进程方面的问题了，
 * 但是如果我们想要用PHP来开发CLI程序，多进程编程是不可或缺的基本技术。
*/



/**pcntl
 *
 * PHP中关于进程控制的方法主要使用到PCNTL（Process Control）扩展,
 * 所以，在进行多进程编程之前，首先要确保你的PHP已经安装了最新的PCNTL扩展，可以输入php -m命令来查看当前已经安装的扩展：
*/


/***
 * 该扩展给我们提供了一组用于进程操作的方法:
 *
pcntl_alarm — 为进程设置一个alarm闹钟信号
pcntl_errno — 别名 pcntl_get_last_error
pcntl_exec — 在当前进程空间执行指定程序
pcntl_fork — 在当前进程当前位置产生分支（子进程）。
pcntl_get_last_error — Retrieve the error number set by the last pcntl function which failed
pcntl_getpriority — 获取任意进程的优先级
pcntl_setpriority — 修改任意进程的优先级
pcntl_signal_dispatch — 调用等待信号的处理器
pcntl_signal_get_handler — Get the current handler for specified signal
pcntl_signal — 安装一个信号处理器
pcntl_sigprocmask — 设置或检索阻塞信号
pcntl_sigtimedwait — 带超时机制的信号等待
pcntl_sigwaitinfo — 等待信号
pcntl_strerror — Retrieve the system error message associated with the given errno
pcntl_wait — 等待或返回fork的子进程状态
pcntl_waitpid — 等待或返回fork的子进程状态
pcntl_wexitstatus — 返回一个中断的子进程的返回代码
pcntl_wifexited — 检查状态代码是否代表一个正常的退出。
pcntl_wifsignaled — 检查子进程状态码是否代表由于某个信号而中断
pcntl_wifstopped — 检查子进程当前是否已经停止
pcntl_wstopsig — 返回导致子进程停止的信号
pcntl_wtermsig — 返回导致子进程中断的信号
 */


/**
 * pcntl_fork — 在当前进程当前位置产生分支（子进程）。
 * 译注：fork是创建了一个子进程，父进程和子进程 都从fork的位置开始向下继续执行，
 * 不同的是父进程执行过程中，得到的fork返回值为子进程号，而子进程得到的是0。
 *
 *
 * fork出的子进程几近于完全的复制了父进程，父子进程共享代码段，虽然父子进程的数据段、堆、栈是相互独立的，
 * 但在一开始，子进程完全复制了父进程的这些数据，但之后的修改互不影响。
 *
 * int pcntl_fork ( void )
 */

//创建5个子进程代码演示：
for($i=0;$i<5;$i++){
    $pid = pcntl_fork();//创建子进程，子进程也是从这里开始执行。

    if($pid==0){
        //由于子进程也会执行循环的代码，所以让子进程退出循环，否则子进程又会创建自己的子进程。
        break;
    }
}


//第一个创建的子进程将睡眠0秒，第二个将睡眠1s，依次类推...主进程会睡眠5秒
sleep($i);

if ($i < 5)
{
    exit("第 " . ($i+1) . " 个子进程退出..." . time() . PHP_EOL);
}
else
{
    exit("父进程退出..." . time() . PHP_EOL);
}


/**
 * 对于pcntl_fork函数要重点理解：“fork是创建了一个子进程，父进程和子进程 都从fork的位置开始向下继续执行，
 * 不同的是父进程执行过程中，得到的fork返回值为子进程号，而子进程得到的是0”
 */


//把上面的代码稍作修改，不让进程退出，然后利用ps命令查看系统状态：

//见下一节