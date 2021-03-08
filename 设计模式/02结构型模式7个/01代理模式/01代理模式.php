<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午1:29
 */


/**
 * 代理模式为其他对象提供一种代理以控制对这个对象的访问。
 * 在某些情况下，一个对象不适合或者不能直接引用另一个对象，而代理对象可以在客户端和目标对象之间起到中介的作用。
 *
 *
 * 优点：
 * 1、职责清晰
 * 2、代理对象可以在客户端和目标对象之间起到中介的作用，这样起到了中介和保护了目标对象的作用。
 * 3、高扩展性
 */



/**顶层接口
 * Interface IGiveGift
 */
interface IGiveGift
{
    function giveRose();
    function giveChocolate();
}

/**追求者
 * Class Follower
 */
class Follower implements IGiveGift
{
    private $girlName;

    function __construct($name='Girl')
    {
        $this->girlName=$name;
    }

    function giveRose()
    {
        echo "{$this->girlName}:这是我送你的玫瑰，望你能喜欢。<br/>";
    }

    function giveChocolate()
    {
        echo "{$this->girlName}:这是我送你的巧克力，望你能收下。<br/>";
    }
}

/**代理
 * Class Proxy
 */
class Proxy implements IGiveGift
{
    private $follower;

    function __construct($name='Girl')
    {
        $this->follower=new Follower($name);
    }

    function giveRose()
    {
        $this->follower->giveRose();
    }

    function giveChocolate()
    {
        $this->follower->giveChocolate();
    }
}


//客户端代码：
$proxy=new Proxy('范冰冰');
$proxy->giveRose();
$proxy->giveChocolate();