<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午5:26
 */


/**
 * 观察者模式（有时又被称为发布-订阅模式）。
 * 在此种模式中，一个目标物件管理所有相依于它的观察者物件，并且在它本身的状态改变时主动发出通知。
 * 这通常透过呼叫各观察者所提供的方法来实现。此种模式通常被用来实现事件处理系统。
 *
 *
 *  优点：
 * 1、一个抽象模型有两个方面，其中一个方面依赖于另一个方面。将这些方面封装在独立的对象中使它们可以各自独立地改变和复用
 * 2、一个对象的改变将导致其他一个或多个对象也发生改变，而不知道具体有多少对象将发生改变，可以降低对象之间的耦合度。
 * 3、一个对象必须通知其他对象，而并不知道这些对象是谁。需要在系统中创建一个触发链，A对象的行为将影响B对象，B对象的行为将影响C对象……，可以使用观察者模式创建一种链式触发机制
 */



//抽象通知者
abstract class Subject
{
    private $observers = array();
    public function  Attach(Observer $observer){
        array_push($this->observers,$observer);
    }
    public function  Detach(Observer $observer){
        foreach($this->observers as $k=>$v) {
            if($v==$observer) {
                unset($this->observers[$k]);
            }
        }
    }
    function  Notify(){
        foreach($this->observers as $v) {
            $v->Update();
        }
    }
}

//具体通知者（Boss和Secretary）
class ConcreteSubject extends Subject
{
    public $subject_state;
}

//抽象观察者
abstract class Observer
{
    public abstract function Update();
}

//具体观察者
class ConcreteObserver extends Observer
{
    private $name;
    private $observerState;
    public $subject;

    public function __construct(ConcreteSubject $_sub,$_name){
        $this->subject = $_sub;
        $this->name = $_name;
    }

    public function  Update(){
        $this->observerState = $this->subject->subject_state;
        echo "观察者".$this->name."的新状态是:".$this->observerState."<br/>";
    }
}




//调用客户端代码：


//前台
$_s = new ConcreteSubject();

//宝银
$baoyin = new ConcreteObserver($_s, "张三");
$jiangchao = new ConcreteObserver($_s,"李四");

//前台记下宝银姜超
$_s->Attach($baoyin);
$_s->Attach($jiangchao);

//前台发现老板回来
$_s->subject_state = "孙总回来了";

//前台发送通知
$_s->Notify();
