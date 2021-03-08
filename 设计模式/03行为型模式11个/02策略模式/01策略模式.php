<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午4:34
 */

/**
 * 策略模式定义了一系列的算法，并将每一个算法封装起来，而且使它们还可以相互替换。
 * 策略模式让算法独立于使用它的客户而独立变化，即封装变化的算法。
 *
 *
 * 策略模式的本质是将算法封装起来。下面看一个常见的代码
 */


function log($driver, $msg) {
    switch ($driver) {
        case 'db':
            /**
             * @var \PDO $db
             */
            $stmt = $db->prepare('INSERT INTO `roach`(`msg`)VALUES(?)');
            $stmt->execute([ $msg ]);
        case 'redis':
            /**
             * @var \Redis $redis
             */
            $redis->lPush('roach:log', $msg);
        default:
            file_put_contents('/tmp/roach.log', $msg, FILE_APPEND| LOCK_EX);
    }
}


/**
 * 以上我们实现了记录日志的简单基本功能，调用端提供driver和msg参数即可，
 * 调用api很简单，log方法里的实现也就用了一个switch，这里有什么问题呢？
 *
 *
 * 以上代码看着很简单，没什么大问题，但是我们考虑一下，是否对修改关闭了，
 * 当我们需要修改某一个driver记录日志的细节时，都需要修改log方法，可见没有对修改关闭；
 * 再看一下，如果我们需要增加kafka驱动，还是需要修改log方法，可见也不是对扩展开放，那么怎么修改呢？
 *
 *
 * 这里就用到了策略模式，下面是应用策略模式实现一个打日志功能
 */


interface ILog
{
    public function log($msg);
}



class LogContext
{
    private $_driver;

    public function setDriver(ILog $driver)
    {
        $this->_driver = $driver;
    }
    public function log($msg)
    {
        $this->_driver->log($msg);
    }
}





class Redis implements ILog
{
    public function log($msg)
    {
        /**
         * @var \Redis $redis
         */
        $redis->lPush('roach:log', $msg);
    }
}

class File implements ILog
{
    public function log($msg)
    {
        file_put_contents('/tmp/roach.log', $msg, FILE_APPEND| LOCK_EX);
    }
}

class Db implements ILog
{

    public function log($msg)
    {
        /**
         * @var \PDO $db
         */
        $stmt = $db->prepare('INSERT INTO `roach`(`msg`)VALUES(?)');
        $stmt->execute([ $msg ]);
    }
}

/**
 * 以上代码是一个策略模式的实现例程，调用端如果想记录日志，通过调用LogContext的log方法即可，
 * 在调用log方法前需要调用setDriver初始化_driver实例。
 * 现在我们再来看是否对修改关闭了，当我们想修改文件日志行为，直接修改类File即可，其他的driver不受影响；
 * 再看是否对扩展开放，当我们想把日志记录到Kafka里，我们增加Kafka类即可，其他driver不受影响。
 */