<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 上午10:01
 */


/*
 *工厂方法模式：
 *定义一个创建对象的接口，让子类决定哪个类实例化。 他可以解决简单工厂模式中的封闭开放原则问题。<www.phpddt.com整理>
 */
interface  people {
    function  jiehun();
}
class man implements people{
    function jiehun() {
        echo '送玫瑰，送戒指！<br>';
    }
}

class women implements people {
    function jiehun() {
        echo '穿婚纱！<br>';
    }
}

interface  createMan {  // 注意了，这里是简单工厂本质区别所在，将对象的创建抽象成一个接口。
    function create();

}
class FactoryMan implements createMan{
    function create() {
        return  new man;
    }
}
class FactoryWomen implements createMan {
    function create() {
        return new women;
    }
}

class  Client {
    // 工厂方法
    function test() {
        $Factory =  new  FactoryMan;
        $man = $Factory->create();
        $man->jiehun();

        $Factory =  new  FactoryWomen;
        $man = $Factory->create();
        $man->jiehun();
    }
}

$f = new Client;
$f->test();