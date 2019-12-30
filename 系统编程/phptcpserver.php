<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/3
 * Time: 下午7:26
 */

#一个简单的 TCP 服务器示例


/**
 * resource socket_create ( int $domain , int $type , int $protocol )
 * 1、domain 参数指定哪个协议用在当前套接字上。
 *     ->AF_INET：IPv4 网络协议。TCP 和 UDP 都可使用此协议。
 *     ->AF_INET6：IPv6 网络协议。TCP 和 UDP 都可使用此协议。
 *     ->AF_UNIX：本地通讯协议。具有高性能和低成本的 IPC（进程间通讯）。
 *
 *
 * 2、type 参数用于选择套接字使用的类型。
 *     ->SOCK_STREAM：提供一个顺序化的、可靠的、全双工的、基于连接的字节流。
 *                    支持数据传送流量控制机制。TCP 协议即基于这种流式套接字。
 *     ->SOCK_DGRAM：提供数据报文的支持。(无连接，不可靠、固定最大长度).UDP协议即基于这种数据报文套接字。
 *     ->SOCK_SEQPACKET：提供一个顺序化的、可靠的、全双工的、面向连接的、固定最大长度的数据通信；
 *                     数据端通过接收每一个数据段来读取整个数据包。
 *     ->SOCK_RAW：提供读取原始的网络协议。这种特殊的套接字可用于手工构建任意类型的协议。
 *                  一般使用这个套接字来实现 ICMP 请求（例如 ping）。
 *     ->SOCK_RDM：提供一个可靠的数据层，但不保证到达顺序。一般的操作系统都未实现此功能。
 *
 *
 * 3、protocol 参数，是设置指定 domain 套接字下的具体协议。
 * 这个值可以使用 getprotobyname() 函数进行读取。
 * 如果所需的协议是 TCP 或 UDP，可以直接使用常量 SOL_TCP 和 SOL_UDP 。
 *
 *
 *
 * 返回值：
 * socket_create() 正确时返回一个套接字，失败时返回 FALSE。要读取错误代码，
 * 可以调用 socket_last_error()。这个错误代码可以通过 socket_strerror() 读取文字的错误说明。
 *
 *
 *
 *
 * 创建并返回一个套接字，也称作一个通讯节点。
 * 一个典型的网络连接由 2 个套接字构成，一个运行在客户端，另一个运行在服务器端。
 */

// 创建一个socket
$servsock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
if($servsock === false){
    $errcode = socket_last_error();
    fwrite(STDERR,'socket create fail:'.socket_strerror($errcode));
    exit(-1);
}



/**
 * socket_bind ( resource $socket , string $address [, int $port = 0 ] ) : bool
 * 绑定 address 到 socket。
 * 该操作必须是在使用 socket_connect() 或者 socket_listen() 建立一个连接之前。
 *
 *
 * 1、socket：用 socket_create() 创建的一个有效的套接字资源。
 *
 * 2、address：
 *      ->如果套接字是 AF_INET 族，那么 address 必须是一个四点分法的 IP 地址（例如 127.0.0.1 ）。
 *      ->如果套接字是 AF_UNIX 族，那么 address 是 Unix 套接字一部分（例如 /tmp/my.sock ）。
 *
 * 3、port （可选）：参数 port 仅仅用于 AF_INET 套接字连接的时候，并且指定连接中需要监听的端口号。
 *
 */
// 绑定ip地址及端口
if(!socket_bind($servsock,'0.0.0.0',8888)){
    $errcode = socket_last_error();
    fwrite(STDERR, "socket bind fail: " . socket_strerror($errcode));
    exit(-1);
}


/**
 * socket_listen ( resource $socket [, int $backlog = 0 ] ) : bool
 */
// 允许多少个客户端来排队连接
if(!socket_listen($servsock,128)){
    $errcode = socket_last_error();
    fwrite(STDERR, "socket listen fail: " . socket_strerror($errcode));
    exit(-1);
}





/**
 * socket_accept ( resource $socket ) : resource
 *
 * After the socket socket has been created using socket_create(),
 * bound to a name with socket_bind(),
 * and told to listen for connections with socket_listen(),
 * this function will accept incoming connections on that socket.
 *
 * Once a successful connection is made,
 * a new socket resource is returned, which may be used for communication.
 *
 *  If there are multiple connections queued on the socket, the first will be used.
 *
 * If there are no pending connections, socket_accept() will block until a connection becomes present.
 *
 * If socket has been made non-blocking using socket_set_blocking() or socket_set_nonblock(), FALSE will be returned.
 *
 *
 * The socket resource returned by socket_accept() may not be used to accept new connections.
 * The original listening socket socket, however, remains open and may be reused.
*/
while (true){
    //响应客户端连接
    echo 'socket已初始化完毕，准备接受请求。阻塞中...'.PHP_EOL;
    $connsock = socket_accept($servsock);


    if($connsock){
        //获取连接过来的客户端ip地址和端口
        socket_getpeername($connsock, $addr, $port);
        echo "client connect server: ip = $addr, port = $port" . PHP_EOL;


        while(true){
            //从客户端读取数据
            $data = socket_read($connsock, 1024);
            if($data === ''){
                //客户端关闭
                socket_close($connsock);
                echo "client close" . PHP_EOL;
                break;
            }else{
                echo 'read from client:' . $data;
                $data = strtoupper($data);  //小写转大写
                socket_write($connsock, $data);  //回写给客户端
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