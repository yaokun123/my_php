<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午5:54
 */


/**
 *迭代器模式：迭代器模式是遍历集合的成熟模式，迭代器模式的关键是将遍历集合的任务交给一个叫做迭代器的对象，
 * 它的工作时遍历并选择序列中的对象，而客户端程序员不必知道或关心该集合序列底层的结构。
 *
 *
 * 使用场景：
 * 1、访问一个聚合对象的内容而无需暴露它的内部表示
 * 2、支持对聚合对象的多种遍历
 * 3、为遍历不同的聚合结构提供一个统一的接口
 */


//抽象迭代器
abstract class IIterator
{
    public abstract function First();
    public abstract function Next();
    public abstract function IsDone();
    public abstract function CurrentItem();
}

//具体迭代器
class ConcreteIterator extends IIterator
{
    private $aggre;
    private $current = 0;
    public function __construct(array $_aggre)
    {
        $this->aggre = $_aggre;
    }

    public function First(){//返回第一个
        return $this->aggre[0];
    }


    public function  Next(){//返回下一个
        $this->current++;
        if($this->current<count($this->aggre)) {
            return $this->aggre[$this->current];
        }
        return false;
    }

    //返回是否IsDone
    public function IsDone(){
        return $this->current>=count($this->aggre)?true:false;
    }

    //返回当前聚集对象
    public function CurrentItem(){
        return $this->aggre[$this->current];
    }
}



//调用客户端测试代码：

$iterator= new ConcreteIterator(array('周杰伦','王菲','周润发'));
$item = $iterator->First();
echo $item.PHP_EOL;
while(!$iterator->IsDone())
{
    echo "{$iterator->CurrentItem()}：请买票！".PHP_EOL;
    $iterator->Next();
}