<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/5
 * Time: 下午2:46
 */

//关键字clone
class Person{
    public $name;
    public $age;

    function __construct($name,$age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    function say(){
        echo "我的名字叫：".$this->name.PHP_EOL;
        echo "我的年龄是：".$this->age.PHP_EOL;
    }
}

$p1 = new Person('张三',20);
$p2 = $p1;//实例化对象后的赋值引用赋值
$p3 = clone $p1;//使用关键字clone可以完成对对象的复制得到新的独立的对象


$p2->name = 'zhangsan';

$p1->say();
$p2->say();
$p3->say();

var_dump($p1);
var_dump($p3);
var_dump($p2);