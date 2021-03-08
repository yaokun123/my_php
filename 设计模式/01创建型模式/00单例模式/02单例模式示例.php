<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 上午10:41
 */

/**
 * 每一种设计模式都是为了解决特定的问题，单例模式从名字就可以看出，是软件系统中只需要一个对象时使用。
 */

/**
 * 如果一个类在系统中只能有一个实例，可以通过如下代码实现：
 * 以下代码是一个标准单例模式的实现，其中的关键实现有一下三点：
 * 1、静态私有实例属性
 * 2、私有化构造函数和克隆函数
 * 3、公有的静态获取实例方法
 */

class Singleton
{
    private static $_instance;
    private function __construct(){}
    private function __clone(){}


    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new self();
            //self::$_instance = new static();
        }
        return self::$_instance;
    }
}


/**
 * 但是在实际的开发中，我们一般不会用以上代码来实现单例，原因有以下两点：
 * 1、以上代码实现单例，在创建对象时，用的是new self()，如果其他类也想实现单例(继承)必须复制以上代码
 * 2、该单例模式在调用时是通过静态方法调用，属于直接依赖关系
 *
 *
 * 上面第一个问题，我们可以通过静态延时绑定来解决，创建对象时，我们将new self()改为new static()，
 * 这样如果有其他类也想实现单例，直接继承该类就好，但是第二个问题还是无法解决
 *
 * 那么第二个问题怎么解决呢？
 *
 * 在实际项目开发中一般使用依赖注入方式实现，单独提供一个DI容器，
 * 靠配置注入方式实现，这样就不是直接依赖关系了。下面提供一个简单的DI容器类
 */


class Di
{
    private static $_pool = [];
    public static function set($key, $config = [])
    {
        self::$_pool[ $key ] = $config;
    }
    public static function get($key)
    {
        if(!isset(self::$_pool[ $key ])) {
            return null;
        }

        $config = self::$_pool[ $key ];
        if(isset($config['class'])) {
            $class = $config['class'];
            unset($config['class']);
            if(!class_exists($class)) {
                throw new \Exception($class.'不存在');
            }

            $object = new $class();
            foreach ($config as $property => $value) {
                $object->$property = $value;
            }

            self::$_pool[ $key ] = $object;
        }

        return self::$_pool[ $key ];
    }
}

/**
 * 下面是使用容器创建一个User类，并且注入了nickname属性
 */

class User
{
    /**
     * @var string
     * @datetime 2020/7/12 10:30 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public $nickname;
}

Di::set('user', [
    'class'    => User::class,
    'nickname' => uniqid()
]);

echo Di::get('user')->nickname.PHP_EOL;

/**
 * 通过以上容器实现单例，解决了上面提到的第二个问题，
 * 我们每个类如果想在项目中实现单例，不用特殊的实现，也不用继承某个类，
 * 我们在调用端通过容器的get方法得到对象，这里的依赖关系属于依赖注入，
 * get方法里的对象是通过配置注入进来的，并且全局是一个单例模式。
 */



