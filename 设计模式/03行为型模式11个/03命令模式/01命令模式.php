<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午4:43
 */

/**
 * 命令模式：在软件系统中，“行为请求者”与“行为实现者”通常呈现一种“紧耦合”。
 * 但在某些场合，比如要对行为进行“记录、撤销/重做、事务”等处理，这种无法抵御变化的紧耦合是不合适的。
 * 在这种情况下，如何将“行为请求者”与“行为实现者”解耦？将一组行为抽象为对象，实现二者之间的松耦合。这就是命令模式。
 *
 *
 * 适用场景：
 * 1、系统需要将请求调用者和请求接收者解耦，使得调用者和接收者不直接交互。
 * 2、系统需要在不同的时间指定请求、将请求排队和执行请求。
 * 3、系统需要支持命令的撤销(Undo)操作和恢复(Redo)操作
 * 4、系统需要将一组操作组合在一起，即支持宏命令
 *
 * 优点：
 * 1、降低对象之间的耦合度。
 * 2、新的命令可以很容易地加入到系统中
 * 3、可以比较容易地设计一个组合命令。
 * 4、调用同一方法实现不同的功能
 *
 *
 * 缺点：
 * 使用命令模式可能会导致某些系统有过多的具体命令类。因为针对每一个命令都需要设计一个具体命令类，
 * 因此某些系统可能需要大量具体命令类，这将影响命令模式的使用。
 */



/**
 * 电视机是请求的接收者，
 *遥控器上有一些按钮，不同的按钮对应电视机的不同操作。
 *抽象命令角色由一个命令接口来扮演，有三个具体的命令类实现了抽象命令接口，
 *这三个具体命令类分别代表三种操作：打开电视机、关闭电视机和切换频道。
 *显然，电视机遥控器就是一个典型的命令模式应用实例。
 */



/**命令接收者
 * Class Tv
 */
class Tv
{
    public $curr_channel=0;
    public function turnOn(){//打开电视机
        echo "The television is on.".PHP_EOL;
    }
    public function turnOff(){//关闭电视机
        echo "The television is off."."<br/>";
    }
    public function turnChannel($channel){//切换频道
        $this->curr_channel=$channel;
        echo "This TV Channel is ".$this->curr_channel."<br/>";
    }
}

/**执行命令接口
 * Interface ICommand
 */
interface ICommand
{
    function execute();
}

/**开机命令
 * Class CommandOn
 */
class CommandOn implements  ICommand
{
    private $tv;
    public function __construct($tv){
        $this->tv=$tv;
    }
    public function execute(){
        $this->tv->turnOn();
    }
}

/**关机命令
 * Class CommandOn
 */
class CommandOff implements  ICommand
{
    private $tv;
    public function __construct($tv){
        $this->tv=$tv;
    }
    public function execute(){
        $this->tv->turnOff();
    }
}

/**切换频道命令
 * Class CommandOn
 */
class CommandChannel implements  ICommand
{
    private $tv;
    private $channel;

    public function __construct($tv,$channel){
        $this->tv=$tv;
        $this->channel=$channel;
    }
    public function execute(){
        $this->tv->turnChannel($this->channel);
    }
}

/**遥控器
 * Class Control
 */
class Control
{
    private $_onCommand;
    private $_offCommand;
    private $_changeChannel;

    public function __construct($on,$off,$channel){
        $this->_onCommand = $on;
        $this->_offCommand = $off;
        $this->_changeChannel = $channel;
    }
    public function turnOn(){
        $this->_onCommand->execute();
    }
    public function  turnOff(){
        $this->_offCommand->execute();
    }
    public function changeChannel(){
        $this->_changeChannel->execute();
    }
}




//测试代码
// 命令接收者 　
$myTv = new Tv();
$on = new CommandOn($myTv);
$off = new CommandOff($myTv);
$channel = new CommandChannel($myTv, 2);


// 命令控制对象　
$control = new Control($on, $off, $channel);
$control->turnOn();
$control->changeChannel();
$control->turnOff();