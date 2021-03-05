<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/5
 * Time: 下午2:59
 */

//有两种方法解决上述浅拷贝问题，一种是使用__clone()方法，另一种是序列与反序列

//第二种：使用序列与反序列方法

class newClass{
    public $newAttr = 'm';
}

class testClass{
    public $attr1;
    public $attr2;
}

$obj = new testClass();
$obj->attr1 = 'a';
$obj->attr2 = new newClass();
var_dump($obj);

//$copy_obj_new = clone $obj;
$copy_obj_new = unserialize(serialize($obj));
$copy_obj_new->attr1 = 'b';
$copy_obj_new->attr2->newAttr = 'n';//这一步会将$obj中的attr2.newAttr也改了

var_dump($obj);
var_dump($copy_obj_new);