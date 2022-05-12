<?php
// 异步

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

//注册连接成功回调
$client->on("connect", function($cli) {
    $cli->send("hello world".PHP_EOL);
});

//注册数据接收回调
$client->on("receive", function($cli, $data){
    echo "Received: ".$data.PHP_EOL;
});

//注册连接失败回调
$client->on("error", function($cli){
    echo "Connect failed".PHP_EOL;
});

//注册连接关闭回调
$client->on("close", function($cli){
    echo "Connection close".PHP_EOL;
});

//发起连接
$client->connect('127.0.0.1', 9501, 0.5);