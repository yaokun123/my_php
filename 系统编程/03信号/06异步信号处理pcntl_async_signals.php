<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/4
 * Time: 下午10:39
 */


/**
 * PHP7.1信号新特性 -- pcntl_async_signals() 方法
 *
 *
 * 一个新的名为 pcntl_async_signals() 的方法现在被引入，
 * 用于启用无需 ticks （这会带来很多额外的开销）的异步信号处理。详情请查看 PHP7.1新特性
 *
 *
 * pcntl_async_signals — 开启/关闭异步信号处理或返回当前的设定
 *
 *
 * bool pcntl_async_signals ([ bool $on = NULL ] )
 *
 *
 * 如果不传参数, pcntl_async_signals() 返回当前是否开启了异步信号处理，
 * 如果传参就是设置是否开启异步信号处理
 */



$status = pcntl_async_signals();
var_dump($status);//bool(false)

pcntl_async_signals(true);

$status = pcntl_async_signals();
var_dump($status);//bool(true)


/**
 *看一个简单demo：
 */



pcntl_async_signals(true); //开启异步信号处理

pcntl_signal(SIGINT, function(){//ctrl+c
    echo '捕获到SIGINT信号' . PHP_EOL;
});

$i = 0;
while(1)
{
    echo $i++ . PHP_EOL;
    sleep(1);
}

/**
 * 以上代码不停的打印数字，当键入ctrl+c 向进程发送SIGINT信号时，打印一句话，
 * 可以看到不需要再把代码放在ticks里了
 */