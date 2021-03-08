<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/5
 * Time: 下午2:51
 */

//__clone() 方法
//使用关键字 clone 克隆一个对象，新创建的对象（复制生成的对象）中的 __clone() 方法会被调用


class Person2{
    private $name;
    private $age;

    function __construct($name,$age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    function say(){
        echo "我的名字叫：".$this->name.PHP_EOL;
        echo "我的年龄是：".$this->age.PHP_EOL;
    }

    function __clone()
    {
        $this->name = "我是假的".$this->name;
        $this->age = 30;
    }
}

$p11 = new Person2("张三", 20);
$p11->say();
$p22 = clone $p11;
$p22->say();