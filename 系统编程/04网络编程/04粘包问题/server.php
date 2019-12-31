<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/3
 * Time: 下午7:26
 */
$servsock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
if($servsock === false){
    $errcode = socket_last_error();
    fwrite(STDERR,'socket create fail:'.socket_strerror($errcode));
    exit(-1);
}

if(!socket_bind($servsock,'0.0.0.0',8888)){
    $errcode = socket_last_error();
    fwrite(STDERR, "socket bind fail: " . socket_strerror($errcode));
    exit(-1);
}

if(!socket_listen($servsock,128)){
    $errcode = socket_last_error();
    fwrite(STDERR, "socket listen fail: " . socket_strerror($errcode));
    exit(-1);
}


while (true){
    echo 'socket已初始化完毕，准备接受请求。阻塞中...'.PHP_EOL;
    $connsock = socket_accept($servsock);


    if($connsock){
        socket_getpeername($connsock, $addr, $port);
        echo "client connect server: ip = $addr, port = $port" . PHP_EOL;


        while(true){
            // 这里只读取一次，由于客户端发送的数据粘在一起，所以会将两个包的数据都读取出来。
            // 详细解决流程可见python版本的网络编程
            $data = socket_read($connsock, 1024);
            if($data === ''){
                socket_close($connsock);
                echo "client close" . PHP_EOL;
                break;
            }else{
                echo 'read from client:' . $data;
                $data = strtoupper($data);
                socket_write($connsock, $data);
            }
        }
    }
}

socket_close($servsock);



/**
 * 但其实这个TCP服务器是有问题的，它一次只能处理一个客户端的连接和数据传输，
 * 这是因为一个客户端连接过来后，进程就去负责读写客户端数据，
 * 当客户端没有传输数据时，tcp服务器处于阻塞读状态，无法再去处理其他客户端的连接请求了。
 */


/**
 * 解决这个问题的一种办法就是采用多进程服务器，每当一个客户端连接过来，
 * 服务器开一个子进程专门负责和该客户端的数据传输，而父进程仍然监听客户端的连接，
 * 但是起进程的代价是昂贵的，这种多进程的机制显然支撑不了高并发。
*/


/**
 * 另一个解决办法是使用IO多路复用机制，
 * 使用php为我们提供的socket_select方法，它可以监听多个socket，
 * 如果其中某个socket状态发生了改变，比如从不可写变为可写，从不可读变为可读，这个方法就会返回，
 * 从而我们就可以去处理这个socket，处理客户端的连接，读写操作等等。来看php文档中对该socket_select的介绍
 *
 *
 * socket_select — Runs the select() system call on the given arrays of sockets with a specified timeout
 * socket_select  ---  在给定的几组sockets数组上执行 select() 系统调用，用一个特定的超时时间。
 *
 * int socket_select ( array &$read , array &$write , array &$except , int $tv_sec [, int $tv_usec = 0 ] )
 * socket_select() 接受几组sockets数组作为参数，并监听它们改变状态
 *
 * 这些基于BSD scokets 能够识别这些socket资源数组实际上就是文件描述符集合。
 * 三个不同的socket资源数组会被同时监听。
 *
 * 这三个资源数组不是必传的， 你可以用一个空数组或者NULL作为参数，
 * 不要忘记这三个数组是以引用的方式传递的，在函数返回后，这些数组的值会被改变。
 *
 *
 * socket_select() 调用成功返回这三个数组中状态改变的socket总数，
 * 如果设置了timeout，并且在timeout之内都没有状态改变，这个函数将返回0，
 * 出错时返回FALSE，可以用socket_last_error() 获取错误码。
 */



//使用 socket_select() 优化之前 phptcpserver.php 代码：
//见下一节