<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 下午4:06
 */


/**
 * 模板模式准备一个抽象类，将部分逻辑以具体方法以及具体构造形式实现，然后声明一些抽象方法来迫使子类实现剩余的逻辑。
 * 不同的子类可以以不同的方式实现这些抽象方法，从而对剩余的逻辑有不同的实现。
 * 先制定一个顶级逻辑框架，而将逻辑的细节留给具体的子类去实现。
 */


class LogLevel
{
    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const CRITICAL  = 'critical';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const INFO      = 'info';
    const DEBUG     = 'debug';
}


abstract class ILogger
{
    public static function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
    abstract public function log($level, $message, array $context = array());
}



class File extends ILogger
{
    protected $_fileName;
    public function setFileName($fileName)
    {
        $this->_fileName = $fileName;
    }
    public function log($level, $message, array $context = array())
    {
        $message = '{datetime} {level} {ip} {url} '.$message.PHP_EOL;
        $context['datetime'] = date('Y-m-d H:i:s');
        $context['level']    = $level;
        $context['ip']       = $_SERVER['REMOTE_ADDR'];
        $context['url']      = $_SERVER['REQUEST_URI'];
        $message = self::interpolate($message, $context);

        file_put_contents($this->_fileName, $message, FILE_APPEND | LOCK_EX);
    }
}


class Db extends ILogger
{
    protected $_pdo;
    public function setPdo(\PDO $pdo)
    {
        $this->_pdo = $pdo;
    }
    public function log($level, $message, array $context = array())
    {
        $message = self::interpolate($message, $context);
        $stmt = $this->_pdo->prepare('INSERT INTO `roach_log`(`level`,`ip`,`url`,`msg`,`add_time`)VALUES(?,?,?,?,?)');
        $stmt->execute([
            $level,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['REQUEST_URI'],
            self::interpolate($message, $context),
            time()
        ]);
    }
}


//测试
$file = new File();
$file->setFileName('/tmp/file.log');
$file->debug('test1');
$file->error('test2');


/**
 * 分析以上代码，ILogger是抽象的模板类，实现了部分逻辑，但是log方法没有实现，交给子类实现，
 * 作者实现了File和Db子类，如果您感兴趣可以实现其他类，如Redis、Kafka等。
 *
 *
 *
 * 看过策略模式文章的同学也许有疑问了，这不是策略模式吗？
 * 把log方法封装了起来，从本质上来讲算是解决了不同算法的问题，但是严格上来讲，缺少了一个Context对象，
 * 不过不重要，只要我们的代码符合开闭原则，我们以设计模式六大原则来编写代码就可以了，严格按照模式来编写代码是没有意义的。
 */