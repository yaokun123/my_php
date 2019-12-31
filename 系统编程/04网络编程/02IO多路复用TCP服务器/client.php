<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/12/31
 * Time: 上午10:20
 */

$client_socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

socket_connect($client_socket,'127.0.0.1',8888);

while (1){
    fwrite(STDOUT,'>>');

    $content = fgets(STDIN);

    socket_write($client_socket,$content);

    $data = socket_read($client_socket,1024);
    echo $data.PHP_EOL;
}