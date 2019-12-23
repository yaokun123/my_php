<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午8:38
 */

//普通类
class common{

}

$c1 = new common();
$c2 = new common();


if($c1 === $c2){
    echo '是一个对象'.PHP_EOL;
}else{
    echo '不是一个对象'.PHP_EOL;
}


echo "====================".PHP_EOL;


// 单例模式---封锁new操作

class sigle{
    protected static $ins = null;
    final protected function __construct()
    {
    }

    public static function getIns(){
        if(!self::$ins){
            self::$ins = new self();
        }
        return self::$ins;
    }

    final protected function __clone()
    {

    }
}
$s1 = sigle::getIns();
$s2 = sigle::getIns();
if($s1 === $s2){
    echo '是一个对象'.PHP_EOL;
}else{
    echo '不是一个对象'.PHP_EOL;
}

