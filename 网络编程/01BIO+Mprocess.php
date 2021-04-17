<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/4/17
 * Time: 下午1:55
 */


$socket = socket_create(AF_INET,SOCK_STREAM,0);
if($socket < 0){
    echo 'failed to create socket:'.socket_strerror($socket).PHP_EOL;
    exit();
}

$ret = socket_bind($socket,'0.0.0.0','7777');
if($ret < 0){
    echo 'failed to bind socket:'.socket_strerror($ret).PHP_EOL;
    exit();
}

socket_listen($socket,128);
/*if($ret){
    echo 'failed to listen to socket:'.socket_strerror($ret).PHP_EOL;
    exit();
}*/


while (true){
    $conn = @socket_accept($socket);

    if(pcntl_fork() == 0){//子进程
        echo '新开一个进程处理新连接';
        while (true){
            $recv = socket_read($conn,8192);
            if(!$recv){
                echo '客户端断开连接';
                socket_close($conn);
                exit();
            }
            //处理数据
            $send_data = "server:".$recv;
            socket_write($conn,$send_data);
        }
    }else{
        socket_close($conn);
    }
}