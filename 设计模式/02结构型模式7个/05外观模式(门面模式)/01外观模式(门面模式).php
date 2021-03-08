<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午3:31
 */


/**
 * 门面模式（有时候也称外观模式）是指提供一个统一的接口去访问多个子系统的多个不同的接口，
 * 它为子系统中的一组接口提供一个统一的高层接口。使用子系统更容易使用。
 */


/**
 * 案例：
 * 炒股票，新股民不了解证券知识做股票，是很容易亏钱的，需要学习的知识太多了，
 * 这样新手最好把炒股的事情委托给基金公司，基金公司了解证券知识，那么新股民把自己的股票托管给基金公司去运营，
 * 这样新股民不必了解哪只股票的走势就可以完成股票的买卖。基金公司在这里就是一个门面，针对于新股民的门面。
 */




/**阿里股票
 * Class Ali
 */
class Ali
{
    function buy()
    {
        echo "买入阿里股票<br/>";
    }

    function sell()
    {
        echo "卖出阿里股票<br/>";
    }
}

/**万达股票
 * Class Wanda
 */
class Wanda
{
    function buy()
    {
        echo "买入万达股票<br/>";
    }

    function sell()
    {
        echo "卖出万达股票<br/>";
    }
}

/**京东股票
 * Class Jingdong
 */
class Jingdong
{
    function buy()
    {
        echo "买入京东股票<br/>";
    }

    function sell()
    {
        echo "卖出京东股票<br/>";
    }
}




/**门面模式核心角色
 * Class FacadeCompany
 */
class FacadeCompany
{
    private $ali;

    private $wanda;

    private $jingdong;

    function __construct()
    {
        $this->ali = new Ali();
        $this->jingdong = new Jingdong();
        $this->wanda = new Wanda();
    }

    function buy()
    {
        $this->wanda->buy();
        $this->ali->buy();
    }

    function sell()
    {
        $this->jingdong->sell();
    }

}


//客户端调用代码：
$lurenA=new FacadeCompany();
$lurenA->buy();
$lurenA->sell();