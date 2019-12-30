<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:05
 */

//注册一个tick回调函数
register_tick_function(function(){
    echo "触发了ticks " .  microtime(TRUE) . PHP_EOL;
});


$a = 0;
//每执行6条语句触发一个tick
declare(ticks=6)
{
    while(1)
    {
        $a++;
        echo '$a = ' . $a . PHP_EOL;
        sleep(1);
    }
}



$a = 1;
$a = 2;
$a = 3;


//了解了ticks机制，我们来演示下 pcntl_signal 函数：

//见下一节