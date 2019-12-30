<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午9:28
 */

/**
 * 信号是事件发生时对进程的通知机制，有时又称为软件中断。
 * 一个进程可以向另一个进程发送信号，比如子进程结束时都会向父进程发送一个SIGCHLD（20号信号）来通知父进程，
 * 所以有时信号也被当作一种进程间通信的机制。
 */


/**
 * 在linux系统下，通常我们使用 kill -9 XXPID来结束一个进程，其实这个命令的实质就是向某进程发送 SIGKILL（9号信号），
 * 对于在前台运行的程序我们通常用 Ctrl + c 快捷键来结束运行，该快捷键的实质是向当前进程发送 SIGINT (2号信号)，
 * 而进程收到该信号的默认行为是结束运行。我们可以用命令  kill -l  来查看系统的信号列表：
 */


/**kill -l
 *
 * 其中1 ~ 31 号信号为标准信号或者传统信号，而大于31号信号为实时信号，这里我们主要介绍 标准信号。
 * 进程收到一个信号时，视信号的不同，有以下几种不同的行为：
 *
 *
 *      ->忽略信号，进程就像没收到过信号一样，比如父进程收到子进程发送的 SIGCHLD 信号
 *      ->结束进程， 比如进程收到 SIGINT （Ctrl + c） 信号
 *      ->暂停运行
 *      ->从之前的暂停状态恢复运行
 */



/**
 * PHP的pcntl扩展以及posix扩展为我们提供了若干操作信号的方法：
 *
pcntl_signal_dispatch — 调用等待信号的处理器
pcntl_signal_get_handler — Get the current handler for specified signal
pcntl_signal — 安装一个信号处理器
pcntl_sigprocmask — 设置或检索阻塞信号
pcntl_sigtimedwait — 带超时机制的信号等待
pcntl_sigwaitinfo — 等待信号

posix_kill — 向一个进程发送信号
 */



/**
 * pcntl_signal 方法可以让我们自定义进程对信号的处理动作，
 * 但是在linux系统中，SIGKILL（9号信号）和 SIGSTOP （17号信号）这两个信号是无法被我们自己捕获和处理的，
 * SIGKILL总是会结束进程运行，SIGSTOP总是能暂停进程。
 */


/**
 *
 * bool pcntl_signal ( int $signo , callback $handler [, bool $restart_syscalls = true ] )
 *
 *      ->signo：信号编号
 *      ->handler：信号处理器可以是用户创建的函数或方法的名字，
 *          也可以是系统常量 SIG_IGN（译注：忽略信号处理程序）或SIG_DFL（默认信号处理程序）
 */


/**
 * 在PHP中，有自己触发信号回调的机制
 *
 * PCNTL现在使用了ticks作为信号处理的回调机制，ticks在速度上远远超过了之前的处理机制。
 * 这个变化与“用户ticks”遵循了相同的语义。您可以使用declare() 语句在程序中指定允许发生回调的位置。
 * 这使得我们对异步事件处理的开销最小化。
 * 在编译PHP时 启用pcntl将始终承担这种开销，不论您的脚本中是否真正使用了pcntl。
 *
 *
 * 所以，在使用pcntl_signal方法之前，我们先要了解下PHP中的 “用户ticks”，
 * 而 “用户ticks” 又牵涉到 PHP中的流程控制结构 declare
 */



/**
 * declare 结构用来设定一段代码的执行指令。declare 的语法和其它流程控制结构相似：

declare (directive)
    statement

directive 部分允许设定 declare 代码段的行为。
目前只认识两个指令：ticks（更多信息见下面 ticks 指令）以及 encoding（更多信息见下面 encoding 指令）。

declare 代码段中的 statement 部分将被执行——怎样执行以及执行中有什么副作用出现取决于 directive 中设定的指令。
declare 结构也可用于全局范围，影响到其后的所有代码（但如果有 declare 结构的文件被其它文件包含，则对包含它的父文件不起作用）。
 */


/**
 * declare 目前只支持 ticks 和 encoding 两个指令，这里我们只介绍 ticks，
 * 而 encoding指令也很简单，有兴趣可以自己研究
 */



/**
 *Tick（时钟周期）是一个在 declare 代码段中解释器每执行 N 条可计时的低级语句就会发生的事件。
 * N 的值是在 declare 中的 directive 部分用 ticks=N 来指定的。
 *
 * 不是所有语句都可计时。通常条件表达式和参数表达式都不可计时。
 *
 * 在每个 tick 中出现的事件是由 register_tick_function() 来指定的。
 * 更多细节见下面的例子。注意每个 tick 中可以出现多个事件。
 */


//注册一个tick回调函数
register_tick_function(function(){
    echo "触发了ticks " .  microtime(TRUE) . PHP_EOL;
});


//每执行两条语句触发一个tick
declare(ticks=2)
{
    $a = 1;
    $a = 2;
    $a = 3;
    $a = 4;
    $a = 5;
    $a = 6;
}

//declare 结构外面的语句不会触发tick
$a = 1;
$a = 2;
$a = 3;
$a = 4;
$a = 5;



//再看一个例子：
//见下一节


