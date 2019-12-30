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

    $ret = posix_setsid();
    var_dump($ret);


    $fp = @fopen("/dev/tty", "rb");
    if ($fp) {
        echo "子进程会话 " . posix_getsid(0) . " 拥有控制终端\n";
    }   else {
        echo "子进程会话 " . posix_getsid(0) . " 不拥有控制终端\n";
    }
}

