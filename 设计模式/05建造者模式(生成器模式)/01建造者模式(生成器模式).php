<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 上午10:19
 */

/**
 * 建造者模式也称生成器模式，核心思想是将一个复杂对象的构造与它的表示分离，
 * 使同样的构建过程可以创建不同的表示，这样的设计模式被称为建造者模式。
 */


/**
 * 例如：汽车，他的发动机引擎有好多品牌，轮胎也有各种材质，内饰更是千奇百怪；
 * 鸟，他的头、翅膀以及脚有各种颜色和形状，在创建这种复杂对象的时候，我们建议使用建造者模式。
 */


/**具体产品角色  鸟类
 * Class Bird
 */
class Bird
{
    public $_head;
    public $_wing;
    public $_foot;

    function show()
    {
        echo "头的颜色:{$this->_head}<br/>";
        echo "翅膀的颜色:{$this->_wing}<br/>";
        echo "脚的颜色:{$this->_foot}<br/>";
    }
}


/**抽象鸟的建造者(生成器)
 * Class BirdBuilder
 */
abstract class BirdBuilder
{
    protected $_bird;

    function __construct()
    {
        $this->_bird=new Bird();
    }

    abstract function BuildHead();
    abstract function BuildWing();
    abstract function BuildFoot();
    abstract function GetBird();
}


/**具体鸟的建造者(生成器)   蓝鸟
 * Class BlueBird
 */
class BlueBird extends BirdBuilder
{

    function BuildHead()
    {
        // TODO: Implement BuilderHead() method.
        $this->_bird->_head="Blue";
    }

    function BuildWing()
    {
        // TODO: Implement BuilderWing() method.
        $this->_bird->_wing="Blue";
    }

    function BuildFoot()
    {
        // TODO: Implement BuilderFoot() method.
        $this->_bird->_foot="Blue";
    }

    function GetBird()
    {
        // TODO: Implement GetBird() method.
        return $this->_bird;
    }
}




/**玫瑰鸟
 * Class RoseBird
 */
class RoseBird extends BirdBuilder
{

    function BuildHead()
    {
        // TODO: Implement BuildHead() method.
        $this->_bird->_head="Red";
    }

    function BuildWing()
    {
        // TODO: Implement BuildWing() method.
        $this->_bird->_wing="Black";
    }

    function BuildFoot()
    {
        // TODO: Implement BuildFoot() method.
        $this->_bird->_foot="Green";
    }

    function GetBird()
    {
        // TODO: Implement GetBird() method.
        return $this->_bird;
    }
}

/**指挥者
 * Class Director
 */
class Director
{
    /**
     * @param $_builder      建造者
     * @return mixed         产品类：鸟
     */
    function Construct($_builder)
    {
        $_builder->BuildHead();
        $_builder->BuildWing();
        $_builder->BuildFoot();
        return $_builder->GetBird();
    }
}

//调用客户端测试代码:
$director=new Director();

echo "蓝鸟的组成：".PHP_EOL;

$blue_bird=$director->Construct(new BlueBird());
$blue_bird->show();

echo PHP_EOL."Rose鸟的组成：".PHP_EOL;

$rose_bird=$director->Construct(new RoseBird());
$rose_bird->show();