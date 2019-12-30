<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午10:52
 */

/**
 * 控制终端、控制进程
 *
 *
 * 终端是所有输入输出设备的总称，比如键盘，鼠标，显示器都是一个终端
 *
 * 一个会话可以有一个控制终端，一个控制终端被一个会话独占。
 *
 * 会话刚创建的时候是没有控制终端的，但会话组长可以申请打开一个终端，
 * 如果这个终端不是其他会话的控制终端，这时的终端将会成为会话的控制终端，会话组长叫做控制进程。
 */




/**
 * linux下判断一个会话是否拥有控制终端，我们可以尝试打开一个特殊的文件 /dev/tty ,
 * 他指向了真实的控制终端，如果打开成功说明拥有控制终端，反之则没有控制终端。
 */



function isGroupLeader() {//判断当前进程是不是进程组id
    return posix_getpgrp() == posix_getpid();
}


$pid = pcntl_fork();


if ($pid > 0) {//父进程
    echo '父进程的id：'.posix_getpid().PHP_EOL;
    sleep(1);
    $fp = fopen("/dev/tty", "rb");
    if ($fp) {
        echo "父进程会话 " . posix_getsid(0) . " 拥有控制终端\n";
    } else {
        echo "父进程会话 " . posix_getsid(0) . " 不拥有控制终端\n";
    }

    exit(0); // 让父进程退出
}elseif($pid == 0){//子进程


    echo '子进程的id：'.posix_getpid().PHP_EOL;
    if (isGroupLeader()) {
        echo "是进程组组长\n";
    } else {
        echo "不是进程组组长\n";
    }

    // 如果子进程不新建一个会话，那么子进行会继承父进程的会话，从而拥有父进程的会话终端
    // 如果子进程新建一个会话，那么在子进程中会话id就是子进程id，如果没有指定新的终端，那么子进程将不拥有控制终端
    $ret = posix_setsid();
    var_dump($ret);


    $fp = @fopen("/dev/tty", "rb");
    if ($fp) {
        echo "子进程会话 " . posix_getsid(0) . " 拥有控制终端\n";
    }   else {
        echo "子进程会话 " . posix_getsid(0) . " 不拥有控制终端\n";
    }
}

/**
 *
 *
父进程的id：13470
子进程的id：13471
不是进程组组长
/yaokun/my_php/系统编程/01进程组_会话_控制终端_控制进程/04控制终端和控制进程.php:61:
int(13471)
子进程会话 13471 不拥有控制终端------->子进程新开了一个控制终端，但是没有指明控制终端，所以这里子进程是不拥有控制终端的
父进程会话 72423 拥有控制终端
 */