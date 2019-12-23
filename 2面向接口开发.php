<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午7:59
 */

// 共同接口
interface db{
    function conn();
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


// 客户端，看不到mysql 和 sqlite的内部细节的
//只知道，他们实现了db接口

$mysql = new mysql();
$mysql->conn();


$sqlite = new sqlite();
$sqlite->conn();


// 如果连 mysql 和 sqlite 这两个类都不希望客户端知道
// 那么可以使用简单工厂模式（见3简单工厂模式.php）