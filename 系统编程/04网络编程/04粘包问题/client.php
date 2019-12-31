<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/12/31
 * Time: 上午10:20
 */

$client_socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

socket_connect($client_socket,'127.0.0.1',8888);




// 这里连续发了两个包，操作系统的Nagle会将这两个包连在一起
socket_write($client_socket,'hello');
socket_write($client_socket,'world');

$data = socket_read($client_socket,1024);
echo $data.PHP_EOL;
