<?php
// 每隔2000ms触发一次
// 可以使用 swoole_timer_clear 清除此定时器，参数为定时器ID
swoole_timer_tick(2000,function(){
    echo "tick-2000ms".PHP_EOL;
});

//3000ms后执行此函数
swoole_timer_after(3000,function(){
    echo "after 3000ms".PHP_EOL;
});