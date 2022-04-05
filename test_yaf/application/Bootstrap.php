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
}