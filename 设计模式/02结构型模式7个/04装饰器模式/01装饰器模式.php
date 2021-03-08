<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午2:48
 */


/**
 * 装饰器模式又叫装饰者模式。装饰模式是在不必改变原类文件和使用继承的情况下，
 * 动态地扩展一个对象的功能。它是通过创建一个包装对象，也就是装饰来包裹真实的对象。
 */

/**组件对象接口
 * Interface IComponent
 */
interface IComponent
{
    function Display();
}


/**待装饰对象
 * Class Person
 */
class Person implements IComponent
{
    private $name;

    function __construct($name)
    {
        $this->name=$name;
    }

    function Display()
    {
        echo "装扮的：{$this->name}".PHP_EOL;
    }
}

/**所有装饰器父类
 * Class Clothes
 */
class Clothes implements IComponent
{
    protected $component;

    function Decorate(IComponent $component)
    {
        $this->component=$component;
    }

    function Display()
    {
        if(!empty($this->component))
        {
            $this->component->Display();
        }
    }

}

//------------------------------具体装饰器----------------

class PiXie extends Clothes
{
    function Display()
    {
        echo "皮鞋  ";
        parent::Display();
    }
}

class QiuXie extends Clothes
{
    function Display()
    {
        echo "球鞋  ";
        parent::Display();
    }
}

class Tshirt extends Clothes
{
    function Display()
    {
        echo "T恤  ";
        parent::Display();
    }
}

class Waitao extends Clothes
{
    function Display()
    {
        echo "外套  ";
        parent::Display();
    }
}



//调用客户端测试代码：
$Yaoming=new Person("姚明");
$aTai=new Person("A泰斯特");

$pixie=new PiXie();
$waitao=new Waitao();

$pixie->Decorate($Yaoming);
$waitao->Decorate($pixie);
$waitao->Display();

echo "<hr/>";

$qiuxie=new QiuXie();
$tshirt=new Tshirt();

$qiuxie->Decorate($aTai);
$tshirt->Decorate($qiuxie);
$tshirt->Display();