<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午10:39
 */


/**
 * 会话
 *
 * 会话（session）是若干进程组的集合，会话中的一个进程组为会话组长（session leader），会话ID即为这个会话组长的进程组id，
 * PHP中可以使用函数 posix_getsid(int $pid)  来获取指定进程的会话id，
 * 也可以使用函数 posix_setsid() 来创建一个新的会话，此时该进程成为新会话的会话组长，
 * 该函数调用成功返回新创建的会话ID，或者在失败出错时返回-1，
 *
 * 注意linux中调用 posix_setsid() 函数的进程不能是进程组长，否则会调用失败，这是由于一个进程组中的进程不能同时跨多个会话。
 */


function isGroupLeader() {//判断当前进程是不是进程组id
    return posix_getpgrp() == posix_getpid();
}


echo "当前会话id: " . posix_getsid(0) . PHP_EOL; //传0表示获取当前进程的会话id
echo "当前进程id: " .posix_getpid().PHP_EOL;
echo "当前进程组id: " .posix_getpgrp().PHP_EOL;

if (isGroupLeader()) {
    echo "当前进程是进程组长，不能创建会话\n";
}




$ret = posix_setsid();  //创建一个新会话
var_dump($ret);  //由于当前进程是进程组长，此处会返回-1, 表示调用失败



/**
 *
 *
当前会话id: 15822
当前进程是进程组长
/yaokun/test/my_php/phpsysprogram/daemonprocess2.php:37:
int(-1)
 */


/**
 * 如果是在phpstorm中运行，因为有了phpstorm作为父进程也就是会话组长，主进程就不是进程组长了，所以可以创建会话。
 * 这就是上一节中推荐在终端中运行脚本文件的原因。
 */



/**
 * 那该如何新建会话呢，我们注意到前面使用pcntl_fork() 创建了一个子进程后，
 * 这个子进程就不是进程组长，所以可以利用子进程来创建新会话。
 */


//见下一节