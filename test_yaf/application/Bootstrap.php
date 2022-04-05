<?php

// 这个类也必须继承自Yaf_Bootstrap_Abstract.
// 实例化成功之后, 所有在Bootstrap类中定义的, 以_init开头的方法, 都会被依次调用,
// 而这些方法都可以接受一个Yaf_Dispatcher实例作为参数

// 调用的次序, 和申明的次序相同
class Bootstrap extends Yaf_Bootstrap_Abstract{

    public function _initConfig() {
        $config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set("config", $config);
    }

    public function _initDefaultName(Yaf_Dispatcher $dispatcher) {
        $dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
    }

    // 注册插件
    public function _initPlugins(Yaf_Dispatcher $dispatcher){
        $user = new UserPlugin();
        $dispatcher->registerPlugin($user);
    }

    // 注册路由协议
    // 事实上,路由组件有两个部分：路由器(Yaf_Router)和路由协议(Yaf_Route_Abstract).
    // 我们只有一个路由器,但我们可以有许多路由协议. 路由器主要负责管理和运行路由链,它根据路由协议栈倒序依次调用各个路由协议, 一直到某一个路由协议返回成功以后, 就匹配成功.
    public function _initRoute(Yaf_Dispatcher $dispatcher){

        // 默认情况下,我们的路由器是Yaf_Router, 而默认使用的路由协议是Yaf_Route_Static,是基于HTTP路由的, 它期望一个请求是HTTP请求并且请求对象是使用Yaf_Request_Http

        /**
         *
        Yaf_Route_Simple
        Yaf_Route_Supervar
        Yaf_Route_Static（ 默认的路由协议 ）
        Yaf_Route_Map
        Yaf_Route_Rewrite
        Yaf_Route_Regex
         */

        //通过派遣器得到默认的路由器
        $router = Yaf_Dispatcher::getInstance()->getRouter();

        // 一旦我们有了路由器实例,我们就能通过它来添加我们自定义的一些路由协议：
        // $router->addRoute('myRoute', $route);
        // $router->addRoute('myRoute1',$route);

        // 还可以添加配置中的路由
    }
}