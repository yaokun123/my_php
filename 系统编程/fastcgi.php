<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/5
 * Time: 下午8:17
 */

/**
 * FastCGI协议是在CGI协议的基础上发展出来的，FastCGI程序本身监听某个socket然后等待来自web服务器的连接，
 * 而不是像CGI程序是由web服务器 fork-exec，所以FastCGI本身是一个服务端程序，而web服务器对它来说则是客户端。
 */



/**
 * FastCGI程序和web服务器之间通过可靠的流式传输（Unix Domain Socket或TCP）来通信，
 * 相对于传统的CGI程序，有环境变量和标准输入输出，而FastCGI程序和web服务器之间则只有一条socket连接来传输数据，
 * 所以它把数据分成以下多种消息类型：
 */

#define FCGI_BEGIN_REQUEST       1          表示一个请求的开始
#define FCGI_ABORT_REQUEST       2          表示服务器希望终止一个请求
#define FCGI_END_REQUEST         3          表示该请求处理完毕
#define FCGI_PARAMS              4          对应于CGI程序的环境变量，php $_SERVER 数组中的数据绝大多数来自于此
#define FCGI_STDIN               5          对应CGI程序的标准输入，FastCGI程序从此消息获取 http请求的POST数据
#define FCGI_STDOUT              6          对应CGI程序的标准输出，web服务器会把此消息当作html返回给浏览器
#define FCGI_STDERR              7          对应CGI程序的标准错误输出， web服务器会把此消息记录到错误日志中
#define FCGI_DATA                8          ...
#define FCGI_GET_VALUES          9          ...
#define FCGI_GET_VALUES_RESULT  10          ...
#define FCGI_UNKNOWN_TYPE       11          程序无法解析该消息类型
#define FCGI_MAXTYPE (FCGI_UNKNOWN_TYPE)


/**
 *
 * 大家都知道 php-fpm 实现了fastcgi协议，但php-fpm所做的事远不止于此，
 * 他还负责 进程管理（fastcgi进程数控制，重启down调的fastcgi子进程等等），初始化 php 运行环境，以及执行 php 脚本
 */