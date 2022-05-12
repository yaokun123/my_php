<?php

//创建Server对象，监听 127.0.0.1:9501端口
// swoole_server()
$server = new Swoole\Server("127.0.0.1",9501);

//监听连接进入事件
$server->on("Connect",function($server, $fd){
    echo "Client: connect".PHP_EOL;
});

//监听数据接收事件
$server->on("Receive",function($server, $fd, $from_id, $data){
    $server->send($fd, "Server: ".$data);
});

//监听连接关闭事件
$server->on("Close", function ($serv, $fd){
    echo "Client: Close".PHP_EOL;
});


//启动服务器
$server->start();