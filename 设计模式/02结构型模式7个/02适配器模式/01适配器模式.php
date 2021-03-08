<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午1:52
 */

/**
 * 适配器模式（有时候也称包装样式或者包装）将一个类的接口适配成用户所期待的（适配器模式要解决的核心问题）。
 * 一个适配允许通常因为接口不兼容而不能在一起工作的类工作在一起，做法是将类自己的接口包裹在一个已存在的类中。
 *
 *
 * 适用场景：
 * 1、接口中规定了所有要实现的方法
 * 2、但要有一个实现此接口的具体类，只用到了其中的几个方法，而其它的方法都是没有用的。
 *
 *
 * 注意事项：
 * 1、充当适配器角色的类就是实现已有接口的抽象类
 * 2、为什么要用抽象类：
 * 此类是不要被实例化的。而只充当适配器的角色，也就为其子类提供了一个共同的接口，但其子类又可以将精力只集中在其感兴趣的地方。
 */


//-------------抽象接口---------------
/**抽象运动员
 * Interface IPlayer
 */
interface IPlayer
{
    function Attack();
    function Defense();
}


/**前锋
 * Class Forward
 */
class Forward implements IPlayer
{

    function Attack()
    {
        echo "前锋攻击".PHP_EOL;
    }

    function Defense()
    {
        echo "前锋防御".PHP_EOL;
    }
}


/**中锋
 * Class Center
 */
class Center implements IPlayer
{

    function Attack()
    {
        echo "中锋攻击".PHP_EOL;
    }

    function Defense()
    {
        echo "中锋防御".PHP_EOL;
    }
}


//--------------待适配对象-----------
/**姚明                 外籍运动员
 * Class Yaoming
 */
class Yaoming
{
    function 进攻()
    {
        echo "姚明进攻".PHP_EOL;
    }

    function 防御()
    {
        echo "姚明防御".PHP_EOL;
    }
}

//------------适配器--------------
/**适配器
 * Class Adapter
 */
class Adapter implements IPlayer
{
    private $_player;

    function __construct()
    {
        $this->_player=new Yaoming();
    }

    function Attack()
    {
        $this->_player->进攻();
    }

    function Defense()
    {
        $this->_player->防御();
    }
}


// 客户端测试代码：
$player1=new Forward();

echo "前锋上场:".PHP_EOL;
$player1->Attack();
$player1->Defense();

echo "------".PHP_EOL;

echo "姚明上场:".PHP_EOL;
$yaoming=new Adapter();
$yaoming->Attack();
$yaoming->Defense();