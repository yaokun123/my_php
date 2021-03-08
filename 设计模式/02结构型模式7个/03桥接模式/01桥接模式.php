<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午2:16
 */


/**
 * 在软件系统中，某些类型由于自身的逻辑，它具有两个或多个维度的变化，那么如何应对这种“多维度的变化”？
 * 这就要使用桥接模式——将抽象部分与它的实现部分分离，使他们可以独立地变化。
 */


/**抽象化角色            抽象路
 * Class AbstractRoad
 */
abstract class AbstractRoad
{
    public $icar;

    abstract function Run();
}

/**具体的             高速公路
 * Class speedRoad
 */
class SpeedRoad extends AbstractRoad
{
    function Run()
    {
        $this->icar->Run();
        echo ":在高速公路上。".PHP_EOL;
    }
}

/**乡村街道
 * Class Street
 */
class Street extends AbstractRoad
{
    function Run()
    {
        $this->icar->Run();
        echo ":在乡村街道上。".PHP_EOL;
    }
}



/**抽象汽车接口
 * Interface ICar
 */
interface ICar
{
    function Run();
}

/**吉普车
 * Class Jeep
 */
class Jeep implements ICar
{
    function Run()
    {
        echo "吉普车跑".PHP_EOL;
    }
}
/**小汽车
 * Class Car
 */
class Car implements ICar
{

    function Run()
    {
        echo "小汽车跑".PHP_EOL;
    }
}


//测试代码：
$speedRoad=new SpeedRoad();
$speedRoad->icar=new Car();
$speedRoad->Run();

echo '----------'.PHP_EOL;

$street=new Street();
$street->icar=new Jeep();
$street->Run();


/**
 *  适用场景：
 *
 *  1．如果一个系统需要在构件的抽象化角色和具体化角色之间增加更多的灵活性，避免在两个层次之间建立静态的联系。

       2．设计要求实现化角色的任何改变不应当影响客户端，或者说实现化角色的改变对客户端是完全透明的。

       3．一个构件有多于一个的抽象化角色和实现化角色，系统需要它们之间进行动态耦合。

       4．虽然在系统中使用继承是没有问题的，但是由于抽象化角色和具体化角色需要独立变化，设计要求需要独立管理这两者。
 */