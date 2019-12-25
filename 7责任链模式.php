<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/24
 * Time: 下午9:00
 */


$lev = $_POST['jubao'];


class board{
    public function process(){
        echo '版主删帖'.PHP_EOL;
    }
}

class admin{
    public function process(){
        echo '管理员封账号'.PHP_EOL;
    }
}

class police{
    public function process(){
        echo '抓起来'.PHP_EOL;
    }
}


if($lev == 1){
    $judge = new board();
    $judge->process();
}else if($lev == 2){
    $judge = new admin();
    $judge->process();
}else if($lev == 3){
    $judge = new police();
    $judge->process();
}



// 责任链模式处理举报问题

$lev2 = $_POST['jubao2'];

class board2{
    protected $power = 1;
    protected $top = 'admin2';
    public function process($lev){
        if($lev <= $this->power){
            echo '版主删帖'.PHP_EOL;
        }else{
            $top = new $this->top;
            $top->process($lev);
        }
    }
}

class admin2{
    protected $power = 2;
    protected $top = 'police2';
    public function process($lev){
        if($lev <= $this->power){
            echo '管理员封账号'.PHP_EOL;
        }else{
            $top = new $this->top;
            $top->process($lev);
        }
    }
}

class police2{
    public function process(){
        echo '抓起来'.PHP_EOL;
    }
}

$judge2 = new board2();
$judge2->process($lev2);