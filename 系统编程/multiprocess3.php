<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/4
 * Time: 下午4:06
 */

$ppid = posix_getpid();//记录父进程的进程号

for($i = 0; $i < 5; $i++){
    $pid = pcntl_fork();

    if($pid==0){
        //由于子进程也会执行循环的代码，所以让子进程退出循环，否则子进程又会创建自己的子进程。
        break;
    }
}

if($ppid == posix_getpid()){
    //父进程
    while(1)
    {
        sleep(1);
    }

}else{
    //子进程
    for($i = 0; $i < 100; $i ++)
    {
        echo "子进程" . posix_getpid() . " 循环 $i ...\n";
        sleep(1);
    }
}


/**
 * 其实上面的程序父子进程还是执行了相同的代码，只是进入的if分支不一样，
 * 而pcntl_exec则可以让子进程完全脱离父进程的影响，去执行新的程序。
 */

//见下一节