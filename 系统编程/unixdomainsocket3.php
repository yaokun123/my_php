<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午9:57
 */


//client端代码：
$client = stream_socket_client("unix:///tmp/unix.sock", $errno, $errstr);

if (!$client) {
    die("connect to server fail: $errno - $errstr");
}



while(true) {
    $msg = fread(STDIN, 1024);

    if ($msg == "quit\n") {
        break;
    }

    fwrite($client, $msg);
    $rt = fread($client, 1024);

    echo $rt . "\n";
}

fclose($client);



