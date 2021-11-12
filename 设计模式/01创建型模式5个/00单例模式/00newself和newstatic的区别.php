<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2021/3/8
 * Time: 上午10:57
 */


/**
 * 1、new static()是在PHP5.3版本中引入的新特性。
 * 2、无论是new static()还是new self()，都是new了一个新的对象。
 * 3、这两个方法new出来的对象有什么区别呢，说白了就是new出来的到底是同一个类实例还是不同的类实例呢？
 */

/**
 * 为了探究上面的问题，我们先上一段简单的代码：
 */

class Father {

    public function getNewFather() {
        return new self();
    }

    public function getNewCaller() {
        return new static();
    }

}

$f = new Father();

print get_class($f->getNewFather());
echo PHP_EOL;
print get_class($f->getNewCaller());
echo PHP_EOL;
/**
 * 注意，上面的代码get_class()方法是用于获取实例所属的类名。
 * 这里的结果是：无论调用getNewFather()还是调用getNewCaller()返回的都是Father这个类的实例。
 * 打印的结果为：FatherFather
 * 到这里，貌似new self()和new static()是没有区别的。我们接着往下走：
 */


print_r('---------------'.PHP_EOL);
class Sun1 extends Father {

}

class Sun2 extends Father {

}

$sun1 = new Sun1();
$sun2 = new Sun2();

print get_class($sun1->getNewFather());//new self()->Father
echo PHP_EOL;
print get_class($sun1->getNewCaller());//new static()->Sun1
echo PHP_EOL;

print_r('---------------'.PHP_EOL);
print get_class($sun2->getNewFather());
echo PHP_EOL;
print get_class($sun2->getNewCaller());

/**
 * 看上面的代码，现在这个Father类有两个子类，由于Father类的getNewFather()和getNewCaller()是public的，所以子类继承了这两个方法。
 * 打印的结果是：FatherSun1FatherSun2
 * 我们发现，无论是Sun1还是Sun2，调用getNewFather()返回的对象都是类Father的实例，而getNewCaller()则返回的是调用者的实例。
 * 即$sun1返回的是Sun1这个类的实例，$sun2返回的是Sun2这个类的实例。
 */


/**
 *
 * 总结：
 * 首先，他们的区别只有在继承中才能体现出来，如果没有任何继承，那么这两者是没有区别的。
 * 然后，new self()返回的实例是万年不变的，无论谁去调用，都返回同一个类的实例，而new static()则是由调用者决定的。
 */