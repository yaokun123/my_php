<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/12/23
 * Time: 下午7:30
 */

/**
 * Class Tiger
 */
abstract class Tiger {
    abstract public function climb();
}

class XTiger extends Tiger{
    public function climb()
    {
        echo '不会爬树'.PHP_EOL;
    }
}


class MTiger extends Tiger{
    public function climb()
    {
        echo '爬树...'.PHP_EOL;
    }
}

class Cat{
    public function climb()
    {
        echo '你咋不上天呢'.PHP_EOL;
    }
}

class Client{
    # 在强语言类型中(c/java)
    //如果$animal的类型是子类，那么只能使用一个子类
    //如果$animal的类型是父类，那么可以使用任何子类
    public static function call(Tiger $animal){
        $animal->climb();
    }

    # 在弱语言类型中(php/python)---多态在弱类型语言中很鸡肋
    //如果$animal的类型不写，那么可以使用任何拥有climb方法的类
    public static function call2($animal){
        $animal->climb();
    }
}

Client::call(new XTiger());
Client::call(new MTiger());
print_r("==================".PHP_EOL);

Client::call2(new XTiger());
Client::call2(new MTiger());
Client::call2(new Cat());