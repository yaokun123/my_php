#!/usr/local/opt/php@7.0/bin/php

<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/5
 * Time: 下午7:29
 */



/**
 *
 *
 * 本篇是系列文章中的第二篇，讲述大名鼎鼎的CGI技术。
 *
 * CGI 全称为Common Gateway Interface （通用网关接口），目的是能够让服务器能够方便的调用外部程序。
 *
 *
 * 原则上只要是拥有读写文件功能的编程语言都可以用来编写CGI程序，例如C,C++,Perl,Visual Basic,Shell等等，
 * 历史上用来编写CGI程序使用最广泛的是Perl语言，连PHP一开始也是用Perl编写的，估计也受这个传统的影响。
 * 服务器在认为这是一个CGI请求时，会调用相关CGI程序，并通过环境变量和标准输出将数据传送给CGI程序，
 * CGI程序处理完数据，生成html，然后再通过标准输出将内容返回给服务器，服务器再将内容交给用户，CGI进程退出。
 * 在这个过程中，服务器的标准输出对应了CGI程序的标准输入，CGI程序的标准输出对应着服务器的标准输入，相当于利用两条管道建立了进程间的通信。
 */



/**
 * CGI的工作原理：
 *
 *
 * www客户端 《----客户端请求一个CGI程序----》 web服务 《----服务器将客户端的请求传送给CGI程序，然后将程序的输出传送给客户端----》  CGI程序
 */



//下面是用C编写的一个CGI小程序，向服务器返回数据只需要将数据写入标准输出即可，可见CGI程序的编写也是相当容易的：


/**
 * cgi.c :
 *
 *
 *
#include <stdio.h>

int main(){
    char MimeType[]="text/html";
    fprintf(stdout, "Content-type: %s\r\n\r\n", MimeType);  //输出响应头，响应头之后要加两个"\r\n"
    fprintf(stdout, "<html><head><title>CGI小程序</title></head>\n");
    fprintf(stdout, "<body>由C编写的CGI小程序</body></html>\n");

    return 0;
}
 */




/**
 * 由于Nginx不支持CGI（支持CGI的升级版FastCGI和SCGI），而Apache原生支持CGI，所以这里选用Apache来举例
 *
 * 首先要对Apache进行一定的配置，使之支持CGI程序,配置如下：
 *
 *
LoadModule cgi_module modules/mod_cgi.so  #注意这项配置是否已经存在，已存在就不要重复配置

AddHandler cgi-script .cgi    #设置cgi程序的扩展名，这里.cgi扩展名文件会被当作CGI来执行

#设置cgi-bin的目录权限，假设 /var/www/html 为你的DocumentRoot
<Directory "/var/www/html">
    AllowOverride None
    Options Indexes ExecCGI  # ExecCGI 表示该目录允许执行CGI，如果没有加这个权限，即使是.cgi也没有权限执行
    Order allow,deny
    Allow from all
</Directory>
 */



/**
 * 重启Apache，把上面的C编写的CGI小程序用gcc编译成可执行文件cgi.out，并放到你配置的CGI目录，这里为 /var/www/html/cgi
 *
 * gcc cgi.c -o test.cgi
 * mv test.cgi /var/www/html/cgi/
 *
 * 然后浏览器访问该文件 ，就可以看到输出结果了（127.0.0.1:8888/cgi/test.cgi）
 */



/**
 * 从以上可以看出，cgi编程和普通的编程并没有太大的区别，cgi小程序也是可以直接运行的可执行文件，
 * 并且大多数编程语言都可以进行cgi编程，这或许也是cgi能够流行起来的原因之一，下面看用 php写一个CGI程序。
 */


// cgi.php
//由于php脚本不是可执行文件，这里用shell的方式来执行php脚本



fwrite(STDOUT, "Content-type: text/html\r\n\r\n");
fwrite(STDOUT, "<html><head></head><body><b>PHP编写的CGI程序演示 ". date("Y-m-d H:i:s") ."</b></body></html>\n");



/**
 * 给cgi.php 添加可执行权限
 *
 * chmod +x cgi.php
 *
 * ./cgi.php
 *
 *
Content-type: text/html

<html><head></head><body><b>PHP编写的CGI程序演示 2017-06-23 15:41:00</b></body></html>
 */



/**
 * 配置Apache支持.php扩展名的CGI小程序
 *
 * AddHandler cgi-script .cgi .php    #设置cgi程序的扩展名，这里 .cgi 和 .php 扩展名文件会被当作CGI来执行
 *
 *
 * 重启Apache，访问该php文件：
 * （127.0.0.1:8888/cgi/cgi.php）
 */


/**
 *
 * 可以看到CGI协议非常简单，但当前为止还没有涉及获取http请求的GET和POST参数，
 * 这就要说前面提到过的环境变量和CGI小程序的标准输入了，下面修改前面的C和PHP小程序，使之支持读取GET和POST参数
 */




/**
 * cgi.c:
 *
 *
 *
 * //cgi.c
#include <stdio.h>
#include <stdlib.h>
extern char **environ;  //调用环境变量
int main()
{

    char MimeType[]="text/html";
    fprintf(stdout, "Content-type: %s\r\n\r\n", MimeType);  //输出响应头，响应头之后要加两个"\r\n"
    fprintf(stdout, "<html><head><title>CGI小程序</title></head><body>\n");

    char **env;

    //循环输出环境变量
    for(env = environ; *env != NULL; env++){
        fprintf(stdout, "%s<br>\n", *env);
    }

    char *query_string = getenv("QUERY_STRING"); //获取环境变量QUERY_STRING,也就是GET参数

    fprintf(stdout, "---------------<br>query_string:%s<br>-------------<br>", query_string);

    fprintf(stdout, "</body></html>\n");

    return 0;
}

 */


/**
 * 再次编译之后浏览器访问(http://127.0.0.1:8888/cgi/test.cgi?user=zyee&age=27)
 *
 *
 * 访问结果：
 *
 *可以看到环境变量中包含了很多有用信息， 包括当前的URL，GET参数，客户端IP地址，请求头等等信息。
 *
 *
 * 下面用PHP脚本来演示获取POST参数
 */



// cgi.php
//由于php脚本不是可执行文件，这里用shell脚本的方式来让php脚本可执行
$post = fread(STDIN, 1024);  // post参数从标准输入读取

fwrite(STDOUT, "Content-type: text/html\r\n\r\n");
fwrite(STDOUT, "<html><head></head><body>");

fwrite(STDOUT, "\npost: $post\n");

fwrite(STDOUT, "<b>PHP编写的CGI程序演示 ". date("Y-m-d H:i:s") ."</b>");
fwrite(STDOUT, "</body></html>\n");



/**
 *
 *
 * curl模拟POST请求
 *
 *
[root@localhost cgi]# curl -d "name=zyee&age=27" "http://127.0.0.1/cgi/cgi.php"
<html><head></head><body>
post: name=zyee&age=27
<b>PHP编写的CGI程序演示 2017-06-23 17:25:26</b></body></html>
 *
 *
 *
 * 上传文件类型的POST请求  ( Multipart/form-data )：
[root@localhost cgi]# curl -F "filename=@/var/www/html/cgi/test.cgi" "http://127.0.0.1/cgi/cgi.php"
 */



/**
 *CGI编写对于有编程基础的人来说是相当容易上手的，那为什么又会被历史所遗弃呢?
 *
 *这就不得不说到CGI的运行方式问题了，每当一个CGI请求过来时，
 * 服务器会fork一个子进程来执行相应的CGI程序，当请求结束时，该CGI进程也随之结束，
 * 这样不停fork进程的开销是非常大的，这是造成CGI程序效率低下的主要原因。
 *
 *
 *
 * 我们可以让CGI程序睡眠一段时间来观察这个过程，比如修改以上程序如下：
 */


/**
#include <stdio.h>
#include <unistd.h>


int main(){
    sleep(10);  //睡眠10秒钟

    char MimeType[]="text/html";
    fprintf(stdout, "Content-type: %s\r\n\r\n", MimeType);  //输出文件类型

    fprintf(stdout, "<html><head><title>CGI小程序</title></head>\n");
    fprintf(stdout, "<body>由C编写的CGI小程序</body></html>");

    return 0;
}
 */




/**
 *然后请求该页面，观察服务器进程信息，可以看到httpd进程fork出的一个子进程在执行CGI程序，并且请求结束该子进程便会退出
 *
 * 正是这种缺陷，所以Apache之后又推出了CGI模块的升级版 mod_cgid 模块
 */



/**
 *
 *
 * 除了优化性能和增加了 ScriptSock指令外，mod_cgid 和 mod_cgi是非常类似的...
 *
 *
 * 在当前的unix操作系统上，一个多线程的服务fork一个子进程代价是非常高昂的，因为fork出来的子进程会复制它父进程的所有线程。
 * 为了避免每次执行CGI程序都引起这个高代价的操作， mod_cgid模块创建一个外部的守护进程来负责创建子进程执行CGI程序，
 * server和这个守护进程间通过unix domain socket来通信。
 */


//在后面我会向大家介绍一种更高级的技术，FastCGI 以及更高效的进程管理器 php-fpm 以及 Apache的 mod_fcgid模块,请大家关注后续文章。