<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 上午9:54
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

class SimpleFactoty {
    // 简单工厂里的静态方法
    static function createMan() {
        return new     man;
    }
    static function createWomen() {
        return new     women;
    }

}

$man = SimpleFactoty::createMan();
$man->jiehun();
$man = SimpleFactoty::createWomen();
$man->jiehun();