<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午10:43
 */

use Workerman\Worker;
require_once '../Workerman/Autoloader.php';

$worker = new Worker('websocket://0.0.0.0:8484');
/**
 * 1、onWorkerStart
 *
 * 设置Worker子进程启动时的回调函数，每个子进程启动时都会执行。
 *
 * 注意：onWorkerStart是在子进程启动时运行的，如果开启了多个子进程($worker->count > 1)，
 * 每个子进程运行一次，则总共会运行$worker->count次。
 *
 *
 *
 * 回调函数的参数
 * $worker：即Worker对象
 */


$worker->onWorkerStart = function($worker)
{
    echo "Worker starting...\n";
};


/**
 * 2、onWorkerReload
 *
 * 此特性不常用到。
 *
 * 设置Worker收到reload信号后执行的回调。
 *
 * 可以利用onWorkerReload回调做很多事情，例如在不需要重启进程的情况下重新加载业务配置文件。
 *
 * 回调函数的参数
 * $worker：即Worker对象
 */


/**
 * 注意
 * 子进程收到reload信号默认的动作是退出重启，以便新进程重新加载业务代码完成代码更新。
 * 所以reload后子进程在执行完onWorkerReload回调后便立刻退出是正常现象。
 *
 * 如果在收到reload信号后只想让子进程执行onWorkerReload，不想退出，
 * 可以在初始化Worker实例时设置对应的Worker实例的reloadable属性为false。
 */
// 设置reloadable为false，即子进程收到reload信号不执行重启
$worker->reloadable = false;
// 执行reload后告诉所有客户端服务端执行了reload
$worker->onWorkerReload = function($worker)
{
    foreach($worker->connections as $connection)
    {
        $connection->send('worker reloading');
    }
};


/**
 * 3、onConnect
 *
 * 当客户端与Workerman建立连接时(TCP三次握手完成后)触发的回调函数。每个连接只会触发一次onConnect回调。
 *
 * 注意：onConnect事件仅仅代表客户端与Workerman完成了TCP三次握手，这时客户端还没有发来任何数据，
 * 此时除了通过$connection->getRemoteIp()获得对方ip，没有其他可以鉴别客户端的数据或者信息，
 * 所以在onConnect事件里无法确认对方是谁。
 * 要想知道对方是谁，需要客户端发送鉴权数据，例如某个token或者用户名密码之类，在onMessage回调里做鉴权。
 *
 *
 * 回调函数的参数
 * $connection：连接对象，即TcpConnection实例，用于操作客户端连接，如发送数据，关闭连接等
 */
$worker->onConnect = function($connection)
{
    echo "new connection from ip " . $connection->getRemoteIp() . "\n";
};


/**
 * 4、onMessage
 *
 * 当客户端通过连接发来数据时(Workerman收到数据时)触发的回调函数
 *
 * 回调函数的参数
 * $connection：连接对象，即TcpConnection实例，用于操作客户端连接，如发送数据，关闭连接等
 * $data：客户端连接上发来的数据，如果Worker指定了协议，则$data是对应协议decode（解码）了的数据
 */
$worker->onMessage = function($connection, $data)
{
    var_dump($data);
    $connection->send('receive success');
};


/**
 * 5、onClose
 *
 * 当客户端连接与Workerman断开时触发的回调函数。不管连接是如何断开的，只要断开就会触发onClose。
 * 每个连接只会触发一次onClose
 *
 *
 * 注意：
 * 如果对端是由于断网或者断电等极端情况断开的连接，这时由于无法及时发送tcp的fin包给workerman，
 * workerman就无法得知连接已经断开，也就无法及时触发onClose。这种情况需要通过应用层心跳来解决
 * 如果使用的是GatewayWorker框架，则直接使用GatewayWorker框架的心跳机制即可
 *
 * 回调函数的参数：
 * $connection：连接对象，即TcpConnection实例，用于操作客户端连接，如发送数据，关闭连接等
 */


$worker->onClose = function($connection)
{
    echo "connection closed\n";
};


/**
 * 6、onBufferFull
 *
 * 每个连接都有一个单独的应用层发送缓冲区，如果客户端接收速度小于服务端发送速度，
 * 数据会在应用层缓冲区暂存，如果缓冲区满则会触发onBufferFull回调。
 *
 * 缓冲区大为TcpConnection::$maxSendBufferSize，默认值为1MB，可以为当前连接动态设置缓冲区大小例如：
 * $connection->maxSendBufferSize = 102400;//设置当前连接发送缓冲区，单位字节
 *
 *
 * 也可以利用TcpConnection::$defaultMaxSendBufferSize 设置所有连接默认缓冲区的大小，例如代码：
 * use Workerman\Connection\TcpConnection;
 * TcpConnection::$defaultMaxSendBufferSize = 2*1024*1024;// 设置所有连接的默认应用层发送缓冲区大小，单位字节
 *
 * 该回调可能会在调用Connection::send后立刻被触发，比如发送大数据或者连续快速的向对端发送数据
 * ，由于网络等原因数据被大量积压在对应连接的发送缓冲区，当超过TcpConnection::$maxSendBufferSize上限时触发。
 *
 * 当发生onBufferFull事件时，开发者一般需要采取措施，例如停止向对端发送数据，
 * 等待发送缓冲区的数据被发送完毕(onBufferDrain事件)等。
 *
 * 当调用Connection::send($A)后导致触发onBufferFull时，不管本次send的数据$A多大，
 * 即使大于TcpConnection::$maxSendBufferSize，本次要发送的数据仍然会被放入发送缓冲区。
 * 也就是说发送缓冲区实际放入的数据可能远远大于TcpConnection::$maxSendBufferSize，
 * 当发送缓冲区的数据已经大于TcpConnection::$maxSendBufferSize时，仍然继续Connection::send($B)数据，
 * 则这次send的$B数据不会放入发送缓冲区，而是被丢弃掉，并触发onError回调。
 *
 *
 * 总结来说，只要发送缓冲区还没满，哪怕只有一个字节的空间，调用Connection::send($A)肯定会把$A放入发送缓冲区，
 * 如果放入发送缓冲区后，发送缓冲区大小超过了TcpConnection::$maxSendBufferSize限制，
 * 则会触发onBufferFull回调。
 *
 * 回调函数的参数
 * $connection
 *
 */
$worker->onBufferFull = function($connection)
{
    echo "bufferFull and do not send again\n";
};


/**
 * 7、onBufferDrain
 *
 * 每个连接都有一个单独的应用层发送缓冲区，缓冲区大小由TcpConnection::$maxSendBufferSize决定，
 * 默认值为1MB，可以手动设置更改大小，更改后会对所有连接生效。
 *
 *
 * 该回调在应用层发送缓冲区数据全部发送完毕后触发。一般与onBufferFull配合使用，
 * 例如在onBufferFull时停止向对端继续send数据，在onBufferDrain恢复写入数据。
 *
 *
 * 回调函数的参数
 * $connection
 */


$worker->onBufferDrain = function($connection)
{
    echo "buffer drain and continue send\n";
};


/**
 * 8、onError
 *
 * 当客户端的连接上发生错误时触发。
 *
 * 目前错误类型有
 *
 * 1.调用Connection::send由于客户端连接断开导致的失败（紧接着会触发onClose回调）
 * (code:WORKERMAN_SEND_FAIL msg:client closed)
 *
 * 2.在触发onBufferFull后(发送缓冲区已满)，仍然调用Connection::send，
 * 并且发送缓冲区仍然是满的状态导致发送失败(不会触发onClose回调)
 * (code:WORKERMAN_SEND_FAIL msg:send buffer full and drop package)
 *
 * 3.使用AsyncTcpConnection异步连接失败时(紧接着会触发onClose回调)
 * (code:WORKERMAN_CONNECT_FAIL msg:stream_socket_client返回的错误消息)
 *
 *
 * 回调函数的参数
 * $connection：连接对象，即TcpConnection实例，用于操作客户端连接，如发送数据，关闭连接等
 * $code：错误码
 * $msg：错误消息
 */
$worker->onError = function($connection, $code, $msg)
{
    echo "error $code $msg\n";
};






// 运行worker
Worker::runAll();