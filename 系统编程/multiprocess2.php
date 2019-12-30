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
 */

//见下一节