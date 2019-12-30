<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午10:29
 */

/**
 * 进程组
 *
 * 每个进程都有一个所属的进程组 (process group)，进程组有一个进程组长（process group leader），
 * 进程组ID即为这个进程组长的进程号，所以判断一个进程是否为进程组组长，只需比较该进称号是否和它的进程组id相等即可，
 * PHP中可以用函数 posix_getpgrp() 获取当前进程的进程组id，用 posix_getpid() 获取当前进程的进程号。
 */


//判断当前进程是不是进程组id
function isGroupLeader() {
    return posix_getpgrp() == posix_getpid();
}


# fork出子进程（父进程返回子进程的id号，子进程中返回0）
$pid = pcntl_fork();


if($pid == 0) {//子进程
    echo '子进程id：'.posix_getpid().'。进程组id：'.posix_getpgrp() . PHP_EOL;
}elseif($pid > 0) {//父进程
    sleep(2);
    echo '========================'.PHP_EOL;
    echo '父进程id：'.posix_getpid().'。进程组id：'.posix_getpgrp() . PHP_EOL;
}

echo "当前进程组gid:" . posix_getpgrp() . PHP_EOL;

if (isGroupLeader()) {
    echo posix_getpid().'Is a process group leader' . PHP_EOL;
}
else {
    echo posix_getpid().'Is not a process group leader' . PHP_EOL;
}