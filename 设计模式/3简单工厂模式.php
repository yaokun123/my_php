<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午7:59
 */

// 共同接口
interface db{
    public function conn();
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


class Factory{
    public static function createDB($type){
        if($type == 'mysql'){
            return new mysql();
        }elseif ($type == 'sqlite'){
            return new sqlite();
        }else{
            throw new Exception("Error db type",1);
        }
    }
}



// 客户端现在不知道服务端有哪些类名了
// 只知道对方开放了一个Factory::createDB方法
// 方法允许传递数据库名称
$mysql = Factory::createDB('mysql');
$mysql->conn();


$sqlite = Factory::createDB('sqlite');
$sqlite->conn();



// 如果以后新增oracle类型怎么办？
// 服务端要修改Factory的内容（java,c++中，改后还要再编译）

// 在面向对象设计法则中，重要的开闭原则---对于修改是封闭的，对于扩展是开放的
// 改进见4工厂模式.php