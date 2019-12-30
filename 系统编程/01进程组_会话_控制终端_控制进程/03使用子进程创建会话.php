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
父进程会话id: 72423---------->iterm终端的会话id
父进程id: 13228--------------
父进程进程组id: 13228--------->父进程是进程组长，所以父进程是不能产生会话id的
不是进程组组长
子进程会话id: 72423---------->继承父进程的会话（iterm终端的会话id）
子进程号id: 13229------------>子进程不是进程组长，因此子进程是可以产生一个新的会话的
子进程组id：13228
/yaokun/my_php/系统编程/01进程组_会话_控制终端_控制进程/03使用子进程创建会话.php:37:
int(13229)
当前进程所属会话ID：13229-------->子进程产生新的会话id就是子进程的id
 *
 * 查看进程之间的关系(pstree)：
 * |-+= 00409 yaok /Applications/iTerm.app/Contents/MacOS/iTerm2 -psn_0_86037
 * | \-+= 72423 yaok /Applications/iTerm.app/Contents/MacOS/iTerm2 --server login -fp yaok---->【会话组长】
 * |   \-+= 72424 root login -fp yaok
 * |     \-+= 72425 yaok -bash
 */