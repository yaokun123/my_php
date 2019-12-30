<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/4
 * Time: 下午3:48
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


while (true){
    sleep(1);//执行死循环不退出

}

/**
 * 上面的代码子进程和父进程都是执行相同的代码，有没有办法让子进程和父进程做不同的事呢，
 * 最简单的办法就是if判断，子进程执行子进程的代码，父进程执行父进程的代码
 *
 *
 * |-+= 00409 yaok /Applications/iTerm.app/Contents/MacOS/iTerm2 -psn_0_86037
 * | |-+= 72423 yaok /Applications/iTerm.app/Contents/MacOS/iTerm2 --server login -fp yaok
 * | | \-+= 72424 root login -fp yaok
 * | |   \-+= 72425 yaok -bash
 * | |     \-+= 15297 yaok php 02多进程pstree.php【主进程】
 * | |       |--- 15298 yaok php 02多进程pstree.php【子进程】
 * | |       |--- 15299 yaok php 02多进程pstree.php【子进程】
 * | |       |--- 15300 yaok php 02多进程pstree.php【子进程】
 * | |       |--- 15301 yaok php 02多进程pstree.php【子进程】
 * | |       \--- 15302 yaok php 02多进程pstree.php【子进程】
 */

//见下一节