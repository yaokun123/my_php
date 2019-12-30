<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:46
 */

/**
 * 信号屏蔽
 *
 *
 * 信号中还有一个重要概念是信号屏蔽，我们可以对进程设置暂时屏蔽某些信号，
 * 进程中有标记哪些信号被屏蔽的一个“列表”，称之为信号屏蔽字，
 * 这时再向进程发送处于被屏蔽的信号，信号不会立即送达给进程，而是被存入称作信号未决字 的“列表”中，
 * 而当这些信号被解除屏蔽时，信号会被立即送达进程。
 */


/**
 *bool pcntl_sigprocmask ( int $how , array $set [, array &$oldset ] )
 *
 *      ->$how：设置pcntl_sigprocmask()函数的行为。 可选值:
 *              SIG_BLOCK: 把信号加入到当前阻塞信号中。
 *              SIG_UNBLOCK: 从当前阻塞信号中移出信号。
 *              SIG_SETMASK: 用给定的信号列表替换当前阻塞信号列表。
 *
 *      ->$set：信号列表。
 *
 *      ->$oldset：oldset是一个输出参数，用来返回之前的阻塞信号列表数组。
 */


//屏蔽 SIGINT(ctrl+c) SIGQUIT(ctrl+\) 信号
pcntl_sigprocmask(SIG_BLOCK, array(SIGINT, SIGQUIT), $oldset);
print_r($oldset);

for($i = 0; $i < 15; $i++)
{
    echo '$i = ' . $i . PHP_EOL;
    sleep(1);

    if ($i == 10)
    {
        echo "解除信号屏蔽\n";
        pcntl_sigprocmask(SIG_UNBLOCK, array(SIGINT), $oldset); // 解除对 SIGINT 的屏蔽
    }
}


/**
 * 程序运行时 我们发送一个SIGINT (Ctrl + c)给进程
 *
 * 可以看到 一旦解除了信号屏蔽，信号屏蔽期间发送的信号会立即送达。
 * 如果程序中的一段代码，我们要保证这段代码在执行过程中每次执行都能完整的执行完，就可以用信号的这个特点，比如：
 */

//见下一节