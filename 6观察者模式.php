<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午9:03
 */

// js版本的观察者模式示例请到/yaokun/test/my_js/观察者模式



// PHP5中提供了观察者observer与被观察者subject的接口


class user implements SplSubject{
    public $lognum;
    public $hobby;

    protected $observers = null;

    public function __construct($hobby)
    {
        $this->lognum = rand(1,10);
        $this->hobby = $hobby;
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer){
        $this->observers->attach($observer);
    }
    public function detach(SplObserver $observer){
        $this->observers->detach($observer);
    }
    public function notify(){
        $this->observers->rewind();

        while ($this->observers->valid()){
            $observer = $this->observers->current();
            $observer->update($this);
            $this->observers->next();

        }
    }

    public function login(){
        // 相关操作

        $this->notify();
    }
}


//安全模块
class secrity implements SplObserver{
    public function update(SplSubject $subject){
        if($subject->lognum < 3){
            echo '这是第'.$subject->lognum.'次安全登录'.PHP_EOL;
        }else{
            echo '这是第'.$subject->lognum.'次登录，异常'.PHP_EOL;
        }
    }
}

//广告模块
class ad implements SplObserver{
    public function update(SplSubject $subject)
    {
        if($subject->hobby == 'sport'){
            echo '运动相关推荐'.PHP_EOL;
        }else{
            echo '其他推荐'.PHP_EOL;
        }
    }
}



// 实施观察
$user = new user('sport');
$user->attach(new secrity());
$user->attach(new ad());

$user->login();