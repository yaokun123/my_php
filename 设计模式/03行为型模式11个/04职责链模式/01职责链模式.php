<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午5:04
 */



/**
 * 职责链模式（又叫责任链模式）包含了一些命令对象和一些处理对象，每个处理对象决定它能处理那些命令对象，
 * 它也知道应该把自己不能处理的命令对象交下一个处理对象，该模式还描述了往该链添加新的处理对象的方法。
 *
 *
 *  适用场景：          
          1、有多个对象可以处理同一个请求，具体哪个对象处理该请求由运行时刻自动确定。

          2、在不明确指定接收者的情况下，向多个对象中的一个提交一个请求。

         3、可动态指定一组对象处理请求。
 */



//申请Model
class Request{
    public $num; //数量
    public $requestType;//申请类型
    public $requestContent;//申请内容
}

//抽象管理者
abstract class Manager
{
    protected $name;
    protected $manager;//管理者上级
    public function __construct($_name){
        $this->name = $_name;
    }
    public function SetHeader(Manager $_mana){//设置管理者上级
        $this->manager = $_mana;
    }
    //申请请求
    abstract public function Apply(Request $_req);

}

//经理
class CommonManager extends Manager
{
    public function __construct($_name){
        parent::__construct($_name);
    }
    public function Apply(Request $_req){
        if($_req->requestType=="请假" && $_req->num<=2) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。".PHP_EOL;
        } else {
            if(isset($this->manager)) {
                $this->manager->Apply($_req);
            }
        }
    }
}

//总监
class MajorDomo extends Manager
{
    public function __construct($_name){
        parent::__construct($_name);
    }

    public function Apply(Request $_req)
    {
        if ($_req->requestType == "请假" && $_req->num <= 5) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。".PHP_EOL;
        } else {
            if (isset($this->manager)) {
                $this->manager->Apply($_req);
            }
        }

    }
}


//总经理
class GeneralManager extends Manager
{
    public function __construct($_name){
        parent::__construct($_name);
    }
    public function Apply(Request $_req){
        if ($_req->requestType == "请假") {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。".PHP_EOL;
        } else if($_req->requestType=="加薪" && $_req->num <= 500) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。".PHP_EOL;
        } else if($_req->requestType=="加薪" && $_req->num>500) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}再说吧。".PHP_EOL;
        }
    }
}



// 调用客户端代码：
$jingli = new CommonManager("李经理");
$zongjian = new MajorDomo("郭总监");
$zongjingli = new GeneralManager("孙总");

//设置直接上级
$jingli->SetHeader($zongjian);
$zongjian->SetHeader($zongjingli);

//申请
$req1 = new Request();
$req1->requestType = "请假";
$req1->requestContent = "小菜请假！";
$req1->num = 1;
$jingli->Apply($req1);

$req2 = new Request();
$req2->requestType = "请假";
$req2->requestContent = "小菜请假！";
$req2->num = 4;
$jingli->Apply($req2);

$req3 = new Request();
$req3->requestType = "加薪";
$req3->requestContent = "小菜请求加薪！";
$req3->num = 500;
$jingli->Apply($req3);

$req4 = new Request();
$req4->requestType = "加薪";
$req4->requestContent = "小菜请求加薪！";
$req4->num = 1000;
$jingli->Apply($req4);
