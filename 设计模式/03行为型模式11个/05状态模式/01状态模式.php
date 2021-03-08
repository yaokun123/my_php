<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午5:16
 */


/**
 * 状态模式当一个对象的内在状态改变时允许改变其行为，这个对象看起来像是改变了其类。
 * 状态模式主要解决的是当控制一个对象状态的条件表达式过于复杂时的情况。
 * 把状态的判断逻辑转移到表示不同状态的一系列类中，可以把复杂的判断逻辑简化。
 *
 * 适用场景：
 * 1、一个对象的行为取决于它的状态，并且它必须在运行时刻根据状态改变它的行为。
 * 2、一个操作中含有庞大的多分支结构，并且这些分支决定于对象的状态。
 *
 * 优点：
 * 1、状态模式将与特定状态相关的行为局部化，并且将不同状态的行为分割开来。
 * 2、所有状态相关的代码都存在于某个ConcereteState中，所以通过定义新的子类很容易地增加新的状态和转换。
 * 3、状态模式通过把各种状态转移逻辑分不到State的子类之间，来减少相互间的依赖
 *
 * 缺点：
 * 1、导致较多的ConcreteState子类
 */


//状态接口
interface IState
{
    function WriteCode(Work $w);
}

//上午工作状态
class AmState implements IState
{
    public function WriteCode(Work $w){
        if($w->hour<=12) {
            echo "当前时间：{$w->hour}点，上午工作；犯困，午休。".PHP_EOL;
        } else {
            $w->SetState(new PmState());
            $w->WriteCode();
        }
    }
}

//下午工作状态
class PmState implements IState
{
    public function WriteCode(Work $w){
        if($w->hour<=17) {
            echo "当前时间：{$w->hour}点，下午工作状态还不错，继续努力。".PHP_EOL;
        } else {
            $w->SetState(new NightState());
            $w->WriteCode();
        }
    }
}

//晚上工作状态
class NightState implements IState{

    public function WriteCode(Work $w)
    {
        if($w->IsDone) {
            $w->SetState(new BreakState());
            $w->WriteCode();
        } else {
            if($w->hour<=21) {
                echo "当前时间：{$w->hour}点，加班哦，疲累至极。".PHP_EOL;
            } else {
                $w->SetState(new SleepState());
                $w->WriteCode();
            }
        }
    }
}

//休息状态
class BreakState implements IState
{

    public function WriteCode(Work $w)
    {
        echo "当前时间：{$w->hour}点，下班回家了。".PHP_EOL;
    }
}

//睡眠状态
class SleepState implements IState
{

    public function WriteCode(Work $w){
        echo "当前时间：{$w->hour}点，不行了，睡着了。".PHP_EOL;
    }
}

//工作状态
class Work
{
    private $current;
    public function Work()
    {
        $this->current = new AmState();
    }

    public $hour;

    public $isDone;

    public function SetState(IState $s)
    {
        $this->current = $s;
    }

    public function WriteCode()
    {
        $this->current->WriteCode($this);
    }
}





//调用客户端测试代码：
$emergWork = new Work();
$emergWork->hour = 9;
$emergWork->WriteCode();


$emergWork->hour = 10;
$emergWork->WriteCode();

$emergWork->hour = 13;
$emergWork->WriteCode();

$emergWork->hour=14;
$emergWork->WriteCode();

$emergWork->hour = 17;
$emergWork->WriteCode();

$emergWork->IsDone = true;
$emergWork->IsDone = false;
$emergWork->hour = 19;
$emergWork->WriteCode();

$emergWork->hour = 22;
$emergWork->WriteCode();
