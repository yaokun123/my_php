<?php

/**
 *  工具类，使用该类来实现自动依赖注入
 */
class Ioc{

    /**
     * 获得类的对象实例
     * @param $className
     * @return object
     * @throws ReflectionException
     */
    public static function getInstance($className){
        $paramArr = self::getMethodParams($className);

        // 反射类(类报告了一个类的有关信息)
        $reflect = new ReflectionClass($className);
        //$reflect->hasMethod('__make');

        // 从给出的参数创建一个新的类实例
        // 创建一个类的新实例，给出的参数将传递到类的构造函数
        // 这个参数以 array 形式传递到类的构造函数
        return $reflect->newInstanceArgs($paramArr);
    }

    /**
     * 获得类的方法参数，只获得有类型的参数
     * @param $className
     * @param string $methodsName
     * @return array
     * @throws ReflectionException
     */
    protected static function getMethodParams($className, $methodsName = '__construct'){
        // 通过反射获得该类
        $reflect = new ReflectionClass($className);
        $paramArr = []; // 记录参数，和参数类型

        // 判断该类是否有构造函数
        if($reflect->hasMethod($methodsName)){

            // 获得构造函数
            $construct = $reflect->getMethod($methodsName);

            // 判断构造函数是否有参数
            $params = $construct->getParameters();

            if (count($params) > 0) {
                // 判断参数类型
                foreach($params as $key=>$param){

                    if($paramClass = $param->getClass()){
                        // 获得参数类型名称
                        $paramClassName = $paramClass->getName();

                        // 获得参数类型
                        $args = self::getMethodParams($paramClassName);
                        $paramArr[] = (new ReflectionClass($paramClass->getName()))->newInstanceArgs($args);
                    }
                }
            }
        }

        return $paramArr;
    }

    public static function make($className, $methodName, $params = []){
        // 获取类的实例
        $instance = self::getInstance($className);

        // 获取该方法所需要依赖注入的参数
        $paramArr = self::getMethodParams($className, $methodName);

        // 调用该方法
        return $instance->{$methodName}(...array_merge($paramArr, $params));
    }
}

// 上面的代码使用php的反射函数，创建了一个容器类，使用该类来实现其他类的依赖注入功能。
// 上面的依赖注入分为两种，一种是构造函数的依赖注入，一种是方法的依赖注入。 我们使用下面三个类来做下测试
// 用于测试多级依赖,B依赖A，A依赖C

class C{
    public function cc(){
        echo 'this is C->cc()';
    }
}

class A{
    protected $cObj;

    public function __construct(C $c){
        $this->cObj = $c;
    }

    public function aa(){
        echo 'this is A->aa()';
    }

    public function aac(){
        $this->cObj->cc();
    }
}

class B{
    protected $aObj;

    /**
     * 测试构造函数依赖注入
     * @param A $a[使用引来注入A]
     */
    public function __construct(A $a){
        $this->aObj = $a;
    }

    /**
     * [测试方法调用依赖注入]
     * @param C $c[依赖注入C]
     * @param $b[这个是自己手动填写的参数]
     */
    public function bb(C $c, $b){
        $c->cc();
        echo "\r\n";

        echo 'params:' . $b;
    }

    /**
     * 验证依赖注入是否成功
     */
    public function bbb(){
        $this->aObj->aac();
    }
}

/**测试构造函数的依赖注入：*/
$bObj = Ioc::getInstance('B');  // 使用Ioc来创建B类的实例，B的构造函数依赖A类，A的构造函数依赖C类。
$bObj->bbb(); // 输出：this is C->cc ， 说明依赖注入成功。
var_dump($bObj);// 打印$bObj // 打印结果，可以看出B中有A实例，A中有C实例，说明依赖注入成功。






/**测试方法依赖注入*/
Ioc::make('B', 'bb', ['this is param b']);
// 输出结果，可以看出依赖注入成功。
//this is C->cc
//params:this is param b
