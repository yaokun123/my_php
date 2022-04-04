<?php
//默认控制器

class IndexController extends Yaf_Controller_Abstract {

    // 首先会执行init方法
    public function init()
    {
       //
    }

    public function indexAction() {//默认Action
        $this->getView()->assign("content", "Hello World");


        // Yaf支持简单的视图引擎, 并且支持用户自定义自己的视图引擎, 比如Smarty.
        // 对于默认模块, 视图文件的路径是在application目录下的views目录中以小写的action名的目录中
    }
}