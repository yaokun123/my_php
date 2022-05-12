<?php
//创建Server对象，监听 127.0.0.1:9501端口，类型为SWOOLE_SOCK_UDP
$server = swoole_server("127.0.0.1", 9501, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

//监听数据接收事件
$server->on("Packet", function($serv, $data, $clientInfo){
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server ".$data);
    var_dump($clientInfo);
});

//启动服务器
$server->start();