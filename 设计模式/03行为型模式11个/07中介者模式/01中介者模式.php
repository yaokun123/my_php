<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午5:34
 */


/**
 * 中介者模式用一个中介者对象来封装一系列的对象交互。
 * 中介者使得各对象不需要显式地相互引用，从而使其松散耦合，而且可以独立地改变它们之间的交互。
 *
 *
 *  适用场景：
 * 1、如果一组对象之间的通信方式比较复杂，导致相互依赖，结构混乱，可以采用中介者模式
 * 2、如果一个对象引用很多对象，并且跟这些对象交互，导致难以复用该对象
 */


//中介者接口：可以是公共的方法，如Change方法，也可以是小范围的交互方法。
//同事类定义：比如，每个具体同事类都应该知道中介者对象，也就是每个同事对象都会持有中介者对象的引用，这个功能可定义在这个类中。

//抽象国家
abstract class Country
{
    protected $mediator;
    public function __construct(UnitedNations $_mediator){
        $this->mediator = $_mediator;
    }
}

//具体国家类
//美国
class USA extends Country
{
    function __construct(UnitedNations $mediator)
    {
        parent::__construct($mediator);
    }

    //声明
    public function Declared($message)
    {
        $this->mediator->Declared($message,$this);
    }

    //获得消息
    public function GetMessage($message){
        echo "美国获得对方消息：$message".PHP_EOL;
    }
}
//中国
class China extends Country
{
    public function __construct(UnitedNations $mediator)
    {
        parent::__construct($mediator);
    }
    //声明
    public function  Declared($message)
    {
        $this->mediator->Declared($message, $this);
    }

    //获得消息
    public function GetMessage($message){
        echo "中方获得对方消息：$message".PHP_EOL;
    }
}

//抽象中介者
//抽象联合国机构
abstract class UnitedNations
{
    //声明
    public abstract function Declared($message,Country $colleague);
}

//联合国机构
class UnitedCommit extends UnitedNations
{
    public $countryUsa;
    public $countryChina;

    //声明
    public function Declared($message, Country $colleague)
    {
        if($colleague==$this->countryChina) {
            $this->countryUsa->GetMessage($message);
        } else {
            $this->countryChina->GetMessage($message);
        }
    }
}



// 调用客户端测试代码：

//测试代码块
$UNSC = new UnitedCommit();

$c1 = new USA($UNSC);
$c2 = new China($UNSC);


$UNSC->countryChina = $c2;
$UNSC->countryUsa =$c1;
$c1->Declared("姚明的篮球打的就是好");
$c2->Declared("谢谢。");