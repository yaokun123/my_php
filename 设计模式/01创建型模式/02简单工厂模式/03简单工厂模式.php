<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午7:59
 */

/**
 * 现实生活中，原始社会自给自足（没有工厂），农耕社会小作坊（简单工厂，民间酒坊），工业革命流水线（工厂方法，自产自销）
 * 现代产业链代工厂（抽象工厂，富士康）。我们的项目代码同样是由简到繁一步一步迭代而来的，但对于调用者来说，却越来越简单。
 *
 * 在日常开发中，凡是需要生成复杂对象的地方，都可以尝试考虑使用工厂模式来代替。
 *
 * 我们把被创建的对象称为“产品”，把创建产品的对象称为“工厂”。
 * 如果要创建的产品不多，只要一个工厂类就可以完成，这种模式叫“简单工厂模式”。
 *
 * 在简单工厂模式中创建实例的方法通常为静态方法，因此简单工厂模式又叫作静态工厂方法模式
 *
 *
 * 简单工厂模式每增加一个产品就要增加一个具体产品类和一个对应的具体工厂类，这增加了系统的复杂度，违背了“开闭原则”。
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



echo '==================================='.PHP_EOL;
//其实工厂模式可以这么改进
class Factory2{
    public static function createDB($type){

        //实际中类名跟$type会有稍微的差别，
        //比如$type='mysql'，类='Mysql'，这时候就要讲$type首字母转换为大写，再去判断类是否存在，
        //只要这个规则定义好就行
        //这样的话扩展就不需要再修改Factory2了，直接新增对应数据库类
        if(class_exists($type)){
            return new $type();
        }else{
            throw new Exception("Error db type",1);
        }
    }
}
$mysql = Factory::createDB('mysql');
$mysql->conn();


$sqlite = Factory::createDB('sqlite');
$sqlite->conn();
