<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/12/24
 * Time: 上午10:18
 */


/**
 * 面向对象编程的优点及目的：可复用、可扩展、可维护、灵活性好
 *
 * 设计模式不是软件设计的起点，而是终点。换句话来说不应该按照23种设计模式去套用，照葫芦画瓢，
 * 而是让自己写的代码自然而然的设计成了各种设计模式的样子。类似无招胜有招。
 * 知乎上有一个大牛给自己制定了一个编码规范：类代码行数不超过400，函数不超过20，嵌套不超过3层，
 * 一旦违反此规范，就重构代码。
 * 有人认为设计模式的价值，他让程序员之间对复杂结构的沟通变得简单。
 */


/**
 * 面向对象编程的七个基本原则
 *
 * 1、开闭原则（对扩展开放，对修改关闭）
 * 2、里氏替换原则（继承）
 * 3、依赖倒置原则（要面向接口编程，不要面向实现编程）
 * 4、单一职责原则（只做一类事）
 * 5、接口隔离原则（控制接口大小）
 * 6、迪米特法则-最少知识原则（不跟“陌生人”说话）
 * 7、合成复用原则
 */


/**
 * 1、开闭原则：对扩展开放，对修改关闭
 * 开闭原则的含义是：当应用的需求改变时，在不修改软件实体的源代码或者二进制代码的前提下，可以扩展模块的功能，使其满足新的需求。
 * 开闭原则是面向对象程序设计的终极目标，它使软件实体拥有一定的适应性和灵活性的同时具备稳定性和延续性。
 *
 * 开闭原则的实现方法：
 * 可以通过“抽象约束、封装变化”来实现开闭原则，即通过接口或者抽象类为软件实体定义一个相对稳定的抽象层，
 * 而将相同的可变因素封装在相同的具体实现类中。
 */



/**
 * 2、里氏替换原则：继承必须确保超类所拥有的性质在子类中仍然成立
 * 里氏替换原则主要阐述了有关继承的一些原则，也就是什么时候应该使用继承，什么时候不应该使用继承，以及其中蕴含的原理。
 * 里氏替换原是继承复用的基础，它反映了基类与子类之间的关系，是对开闭原则的补充，是对实现抽象化的具体步骤的规范。
 *
 * 里氏替换原则的实现方法：
 * 里氏替换原则通俗来讲就是：子类可以扩展父类的功能，但不能改变父类原有的功能。
 * 也就是说：子类继承父类时，除添加新的方法完成新增功能外，尽量不要重写父类的方法。
 */




/**
 * 3、依赖倒置原则：高层模块不应该依赖低层模块，两者都应该依赖其抽象；抽象不应该依赖细节，细节应该依赖抽象
 * 其核心思想是：要面向接口编程，不要面向实现编程。依赖倒置原则是实现开闭原则的重要途径之一，它降低了客户与实现模块之间的耦合。
 * 由于在软件设计中，细节具有多变性，而抽象层则相对稳定，因此以抽象为基础搭建起来的架构要比以细节为基础搭建起来的架构要稳定得多。
 * 这里的抽象指的是接口或者抽象类，而细节是指具体的实现类。
 *
 * 依赖倒置原则的实现方法：
 * 依赖倒置原则的目的是通过要面向接口的编程来降低类间的耦合性
 */




/**
 * 4、单一职责原则：一个类应该有且仅有一个引起它变化的原因，否则类应该被拆分
 * 单一职责原则的核心就是控制类的粒度大小、将对象解耦、提高其内聚性。
 *
 * 单一职责原则的实现方法：
 * 单一职责原则是最简单但又最难运用的原则，需要设计人员发现类的不同职责并将其分离，再封装到不同的类或模块中。
 * 而发现类的多重职责需要设计人员具有较强的分析设计能力和相关重构经验。
 */





/**
 * 5、接口隔离原则：客户端不应该被迫依赖于它不使用的方法 | 一个类对另一个类的依赖应该建立在最小的接口上
 * 要求程序员尽量将臃肿庞大的接口拆分成更小的和更具体的接口，让接口中只包含客户感兴趣的方法。
 * 要为各个类建立它们需要的专用接口，而不要试图去建立一个很庞大的接口供所有依赖它的类去调用。
 *
 * 接口隔离原则的实现方法：
 * 接口尽量小，但是要有限度。为依赖接口的类定制服务。了解环境，拒绝盲从。提高内聚，减少对外交互。
 */




/**
 * 6、迪米特法则：只与你的直接朋友交谈，不跟“陌生人”说话
 * 如果两个软件实体无须直接通信，那么就不应当发生直接的相互调用，可以通过第三方转发该调用。
 * 其目的是降低类之间的耦合度，提高模块的相对独立性。
 * 但是，过度使用迪米特法则会使系统产生大量的中介类，从而增加系统的复杂性，使模块之间的通信效率降低。
 * 所以，在釆用迪米特法则时需要反复权衡，确保高内聚和低耦合的同时，保证系统的结构清晰。
 *
 * 迪米特法则的实现方法：
 *
 */


/**
 * 7、合成复用原则：
 * 它要求在软件复用时，要尽量先使用组合或者聚合等关联关系来实现，其次才考虑使用继承关系来实现。
 * 如果要使用继承关系，则必须严格遵循里氏替换原则。合成复用原则同里氏替换原则相辅相成的，两者都是开闭原则的具体实现规范。
 */







/**
 * 面向对象编程的七个基本原则
 *
 * 1、开闭原则（对扩展开放，对修改关闭）降低维护带来的新风险
 * 2、里氏替换原则（不要破坏继承体系，子类重写方法功能发生改变，不应该影响父类方法的含义）防止继承泛滥
 * 3、依赖倒置原则（高层不应该依赖低层，要面向接口编程）更利于代码结构的升级扩展
 * 4、单一职责原则（一个类只干一件事，实现类要单一）便于理解，提高代码的可读性
 * 5、接口隔离原则（一个接口只干一件事，接口要精简单一）功能解耦，高聚合、低耦合
 * 6、迪米特法则-最少知识原则（不该知道的不要知道，一个类应该保持对其它对象最少的了解，降低耦合度）只和朋友交流，不和陌生人说话，减少代码臃肿
 * 7、合成复用原则（尽量使用组合或者聚合关系实现代码复用，少使用继承）降低代码耦合
 */
