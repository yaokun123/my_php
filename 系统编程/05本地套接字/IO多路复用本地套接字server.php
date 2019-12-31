<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午10:10
 */


/**
 * int stream_select ( array &$read , array &$write , array &$except , int $tv_sec [, int $tv_usec = 0 ] )
 *
 *
 * The stream_select() function accepts arrays of streams and waits for them to change status.
 * Its operation is equivalent to that of the socket_select() function except in that it acts on streams.
 */


//server端代码：

$sockfile = '/tmp/unix.sock';

//如果sock文件已存在，先尝试删除
if (file_exists($sockfile)){
    unlink($sockfile);
}



$server = stream_socket_server("unix://$sockfile", $errno, $errstr);
if (!$server) {
    die("创建unix domain socket fail: $errno - $errstr");
}

$listen_reads = array();
$listen_writes = array();
$listen_excepts = NULL;


$listen_reads[] = $server;

while(true) {
    $can_reads = $listen_reads;
    $can_writes = $listen_writes;
    $num_streams = stream_select($can_reads, $can_writes, $listen_excepts, 0);

    if ($num_streams) {
        foreach ($can_reads as &$sock) {
            if ($server == $sock) {
                $conn = stream_socket_accept($server, 5); //此时一定存在客户端连接，不会有超时的情况
                if ($conn) {
                    // 把客户端连接加入监听
                    $listen_reads[] = $conn;
                    $listen_writes[] = $conn;
                }
            }else{
                $msg = fread($sock, 1024);  //此时一定是可读的
                if (strlen($msg) == 0) {//读取到0个字符，说明客户端关闭
                    fclose($sock);
                    // 从sock监听中移除
                    $key = array_search($sock, $listen_reads);
                    unset($listen_reads[$key]);
                    $key = array_search($sock, $listen_writes);
                    unset($listen_writes[$key]);
                    echo "客户端关闭\n";
                }else {
                    echo "read data: $msg";
                    // 是否可写
                    if (in_array($sock, $can_writes)){
                        fwrite($sock, "read ok!");
                    }
                }
            }
        }
    }


}
fclose($server);


/**
 * 此时这个server就不会有前面那个Warning了，并且支持并发
 */