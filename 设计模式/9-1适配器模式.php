<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/12/25
 * Time: 下午8:50
 */


// 服务器端代码
class tianqi{
    public static function show(){
        $tian =  ['tep'=>28,'win'=>7,'sun'=>'sunny'];
        return serialize($tian);
    }
}



// 客户端调用
$tian = unserialize(tianqi::show());
echo '温度：'.$tian['tep'].PHP_EOL;
echo '风力：'.$tian['win'].PHP_EOL;
echo 'sun:'.$tian['sun'].PHP_EOL;
echo '============================'.PHP_EOL;





// 来了一批java客户端，不认识PHP的串行化后的字符串，怎么办？

// 把服务端代码改了？--旧的客户端又会受影响


// 增加一个适配器(旧的转化为新的)
class AdapterTianqi extends tianqi{
    public static function show()
    {
        $today =  parent::show();
        $today = unserialize($today);
        $today = json_encode($today);
        return $today;
    }
}

//java/python再来调用，通过适配器调用
$tq = AdapterTianqi::show();
$tq = json_decode($tq,true);
echo '温度：'.$tian['tep'].PHP_EOL;
echo '风力：'.$tian['win'].PHP_EOL;
echo 'sun:'.$tian['sun'].PHP_EOL;

