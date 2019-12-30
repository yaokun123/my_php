<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午9:33
 */

/**
 * Socket API一开始是为了解决网络通讯而设计的，而后来在此之上又衍生出一种叫做本地套接字（Unix Domain Socket）的技术，
 * 本地套接字顾名思义，只支持本地的两个进程之间进行通信，虽然网络套接字（Internet Domain Socket）也可以通过本地回环地址（127.0.0.1）
 * 来实现本地进程间通信，但由于本地套接字不需要经过网络协议栈，封包拆包、计算校验和等操作，所以效率上相比网络套接字有一定的优势。
 *
 *
 * 由于本地套接字性能高、稳定、支持非血缘关系的进程间通讯，所以本地套接字也是当下使用最广泛的IPC（进程间通信）的机制之一。
 */



/**
 *Nginx 与 PHP-FPM 之间使用网络套接字（127.0.0.1:9000）和使用本地套接字两种通信方式的性能对比
 *
 * 一般我们都是让 PHP-FPM 监听 127.0.0.1:9000 ，显然这时 Nginx 与 PHP-FPM 是通过网络套接字来实现通讯的，
 * 其实，如果 Nginx和 PHP-FPM运行在同一台服务器上，我们还可以让 PHP-FPM监听本地套接字，接下来就针对这两种方式的性能做一简单的比较。
 *
 *
 * 这里我的Nginx开启两个worker进程
 *
 * 使用网络套接字，Nginx和PHP-FPM配置分别如下：
 *
 *
 * nginx配置：
location ~ \.php$ {
    include /usr/local/etc/nginx/fastcgi.conf;
    fastcgi_intercept_errors on;
    fastcgi_pass   127.0.0.1:9000;#使用网络套接字
}
 *
 * php-fpm配置：
listen = 127.0.0.1:9000
 *
 *
 * 压力测试test.php脚本
<?php
    phpinfo();
 *
 * 压测结果：Requests per second 1635.02
 */




/**
 * 再来看看 Nginx和PHP-FPM 用本地套接字方式的通信，Nginx 和 PHP-FPM 的配置稍作修改：
 *
 *
 * nginx配置：
location ~ \.php$ {
    include /usr/local/etc/nginx/fastcgi.conf;
    fastcgi_intercept_errors on;
    #fastcgi_pass   127.0.0.1:9000;#使用网络套接字
    fastcgi_pass    unix:///dev/shm/php-fpm.sock;#使用本地套接字
}
 *
 * php-fpm配置：
listen = /dev/shm/php-fpm.sock
 *
 *
 * 压测结果：Requests per second 1772.65
 *
 *
 * 以上测试都是多次压测后取得结果，从结果可以看到，本地套接字要比网络套接字的QPS平均高了100多，和我们预期基本一致。
 */



/**
 * PHP的本地套接字编程
 *
 *其实PHP的本地套接字编程和网络套接字基本一致，只是传的参数不一样。
 *
 * PHP为socket编程提供了两套API，一套是 socket_* 系列方法，这在我们前面的系列文章里演示过了，
 * 另一套是 stream_socket_* 系列方法，而后者使用起来更加的方便，这里我们采用后者来演示。
 */


/**
 * stream_socket_*  方法列表:
 *
 *
•stream_socket_accept — 接受由 stream_socket_server 创建的套接字连接
•stream_socket_client — Open Internet or Unix domain socket connection
•stream_socket_enable_crypto — Turns encryption on/off on an already connected socket
•stream_socket_get_name — 获取本地或者远程的套接字名称
•stream_socket_pair — 创建一对完全一样的网络套接字连接流
•stream_socket_recvfrom — Receives data from a socket, connected or not
•stream_socket_sendto — Sends a message to a socket, whether it is connected or not
•stream_socket_server — Create an Internet or Unix domain server socket
•stream_socket_shutdown — Shutdown a full-duplex connection
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


while(true) {
    $conn = stream_socket_accept($server, 5);

    if ($conn) {
        while(true) {
            $msg = fread($conn, 1024);
            if (strlen($msg) == 0){//客户端关闭
                fclose($conn);
                break;
            }
            echo "read data: $msg";
            fwrite($conn, "read ok!");
        }
    }

}
fclose($server);


/**
 * 以上是一个最简单的本地套接字的代码演示，细心的读者可能注意到了server端报的warning，
 * 服务器如果长时间没有客户端过来连接，超过了stream_socket_accept 方法设置的timeout，
 * 服务器端便会报这个警告，事实上，真正的服务端代码是不会是像这样写的，因为这种方式同一时间只能处理一个客户端连接，
 * 如果要实现并发，一种方式就是使用IO多路复用，如同 socket_* 系列方法中有socket_select 方法
 * stream_socket_* 系列方法提供了 stream_select 方法来实现多路复用，使用方法也很相似。
 */

//优化后的代码见下一节

//client端代码见unixdomainsocket3.php