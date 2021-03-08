<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/5
 * Time: 下午2:53
 */

//浅复制与深复制
//clone后属性值为非对象时，复制前后是独立的，没有相互影响。
//属性值为对象时，对象的属性值仍然指向同一个变量（我所理解的浅复制）

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

$copy_obj_new = clone $obj;
$copy_obj_new->attr1 = 'b';
$copy_obj_new->attr2->newAttr = 'n';//这一步会将$obj中的attr2.newAttr也改了

var_dump($obj);
var_dump($copy_obj_new);