<?php

// 定义插件
// 插件要生效, 还需要向Yaf_Dispatcher注册, 那么一般的插件的注册都会放在Bootstra中进行

class UserPlugin extends Yaf_Plugin_Abstract{
    // 在路由之前触发
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    // 路由结束之后触发
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    // 分发循环开始之前被触发
    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response){
    }

    // 分发循环结束之后触发
    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response){
    }

    // 分发之前触发
    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response){
    }

    // 分发结束之后触发
    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response){
    }
}