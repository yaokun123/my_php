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


/**
 * 注意；这里运行脚本的两种方式会导致不同的结果
 *
 * 方式一：在终端执行php xxx.php
子进程id：12893。进程组id：12892----->（注意：这里的进程组id就是父进程的id）
当前进程组gid:12892
12893Is not a process group leader----->（有父进程【12892】在，子进程不可能为进程组长）
========================
父进程id：12892。进程组id：12892----->（注意：这里的进程组id就是父进程的id）
当前进程组gid:12892
12892Is a process group leader----->（父进程就是进程组组长）
 * 查看进程之间的关系如下所示(pstree)：
 * |-+= 00409 yaok /Applications/iTerm.app/Contents/MacOS/iTerm2 -psn_0_86037
 *   \-+= 72423 yaok /Applications/iTerm.app/Contents/MacOS/iTerm2 --server login -fp yaok
 *     \-+= 72424 root login -fp yaok
 *       \-+= 72425 yaok -bash
 *         \-+= 12892 yaok php 01进程组的概念.php----->【父进程id】作为进程组id
 *           \--- 12893 yaok (php)------------------>【子进程id】
 *
 *
 *
 * 方式二：在phpstorm中直接运行
子进程id：13018。进程组id：73450----->（注意：这里的进程组id不是父进程的id了，因为在phpstorm中运行导致父进程也有了父进程phpstorm[73450]）
当前进程组gid:73450
13018Is not a process group leader----->（有父进程【13017】在，子进程不可能为进程组长）
========================
父进程id：13017。进程组id：73450------>（注意：这里的进程组id不是父进程的id了，因为在phpstorm中运行导致父进程也有了父进程phpstorm[73450]）
当前进程组gid:73450
13017Is not a process group leader----->（有父进程【73450】在，子进程不可能为进程组长）
 * 查看进程之间的关系如下所示(pstree)：
 * |-+= 73450 yaok /Applications/PhpStorm.app/Contents/MacOS/phpstorm---->phpstorm作为进程组id
 *   |-+- 13017 yaok /usr/local/Cellar/php@7.0/7.0.31/bin/php /yaokun/my_php/系统编程/01进程组_会话_控制终端_控制进程/01进程组的概
 *   | \--- 13018 yaok (php)
 */


// 推荐使用第一种方式来运行脚本，用第二种方式运行的话会有若干问题