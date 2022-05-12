<?php
$process = new swoole_process(function($pro){
    // todo
    echo "111";

    // $pro->exec();// 执行一个外部程序
},false);// true:不会输出到终端，输出到管道中

$pid = $process->start();
echo $pid.PHP_EOL;


// 回收子进程
swoole_process_wait();