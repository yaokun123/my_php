<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午8:25
 */

/**
 * “工厂方法模式”是对简单工厂模式的进一步抽象化，其好处是可以使系统在不修改原来代码的情况下引进新的产品，即满足开闭原则。
 *
 *
 * 抽象产品只能生产一种产品，此弊端可使用抽象工厂模式解决。
 */

// 共同接口
interface db{
    public function conn();
}

interface Factory{
    public function createDb();
}


// 服务端开发（不知道将会被谁调用）
class mysql implements db{
    //不透明的，想象为java的jar包
    public function conn()
    {
        echo '连接上了mysql'.PHP_EOL;
    }
}

class sqlite implements db{
    public function conn()
    {
        echo '连接上了sqlite'.PHP_EOL;
    }

}

class mysqlFactroy implements Factory{
    public function createDb()
    {
        return new mysql();
    }
}

class sqliteFactory implements Factory{
    public function createDb()
    {
        return new sqlite();
    }
}

// 服务器端添加oracle类
// 前面的代码不用改，新增代码的子类
// 符合面向对象的开闭原则-----对修改是封闭的，对扩展是开放的。
class oracle implements db{
    public function conn()
    {
        echo '连接上了oracle'.PHP_EOL;
    }

}
class oracleFactory implements Factory{
    public  function createDb()
    {
        return new oracle();
    }
}


//=========客户端开始==========

$mysqlFactory = new mysqlFactroy();
$mysql = $mysqlFactory->createDb();
$mysql->conn();


$sqliteFactory = new sqliteFactory();
$sqlite = $sqliteFactory->createDb();
$sqlite->conn();


//后面新增的oracle
$oracleFactory = new oracleFactory();
$oracle = $oracleFactory->createDb();
$oracle->conn();