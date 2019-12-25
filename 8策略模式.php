<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/24
 * Time: 下午9:29
 */

interface Math{
    public function calc($op1,$op2);
}

class MathAdd implements Math{
    public function calc($op1,$op2)
    {
        return $op1 + $op2;
    }
}

class MathSub implements Math{
    public function calc($op1,$op2)
    {
        return $op1 - $op2;
    }
}

class MathMul implements Math{
    public function calc($op1,$op2)
    {
        return $op1 * $op2;
    }
}

class MathDiv implements Math{
    public function calc($op1,$op2)
    {
        return $op1 / $op2;
    }
}


/**
 * 传过来op，根据op制造不同对象
 * if($_POST['op'])
 */


// 封装一个虚拟计算器
class CMath{
    protected $calc = null;

    public function __construct($type)
    {
        $calc = 'Math'.$type;
        $this->calc = new $calc;
    }

    public function calc($op1,$op2){
        return $this->calc->calc($op1,$op2);
    }
}

$type = $_POST['op'];
$cmath = new CMath($type);
echo $cmath->calc($_POST['op1'],$_POST['op2']);



// 其实这个策略根工厂模式很难区分