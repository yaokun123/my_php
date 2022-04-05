<?php

// 入口文件

// 入口文件是所有请求的入口, 一般都借助于rewrite规则, 把所有的请求都重定向到这个入口文件.

define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->run();

// Bootstrap, 也叫做引导程序. 它是Yaf提供的一个全局配置的入口,
// 在Bootstrap中, 你可以做很多全局自定义的工作
//$app->bootstrap()->run(); //可选的调用


// 当bootstrap被调用的时刻, Yaf_Application就会默认的在APPLICATION_PATH下, 寻找Bootstrap.php,