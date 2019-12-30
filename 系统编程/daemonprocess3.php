<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午10:48
 */


function isGroupLeader() {//判断当前进程是不是进程组id
    return posix_getpgrp() == posix_getpid();
}


echo "父进程会话id: " . posix_getsid(0) . PHP_EOL; //传0表示获取当前进程的会话id
echo '父进程id: '.posix_getpid().PHP_EOL;
echo '父进程进程组id: '.posix_getpgrp().PHP_EOL;


$pid = pcntl_fork();


if ($pid > 0) {
    exit(0); // 让父进程退出
} elseif ($pid == 0) {
    if (isGroupLeader()) {
        echo "是进程组组长\n";
    } else {
        echo "不是进程组组长\n";
    }
    echo "子进程会话id: ".posix_getsid(0).PHP_EOL;
    echo "子进程号id: " . posix_getpid() . PHP_EOL;
    echo "子进程组id：" . posix_getpgrp() . PHP_EOL;


    $ret = posix_setsid();
    var_dump($ret);

    echo "当前进程所属会话ID：" . posix_getsid(0) . PHP_EOL;
}



/**
 * 利用子进程成功创建了新的会话。
 *
 *
父进程会话id: 545
父进程id: 741
父进程进程组id: 741
不是进程组组长
子进程会话id: 545
子进程号id: 742
子进程组id：741
/yaokun/test/my_php/phpsysprogram/daemonprocess3.php:37:
int(742)
当前进程所属会话ID：742
 */