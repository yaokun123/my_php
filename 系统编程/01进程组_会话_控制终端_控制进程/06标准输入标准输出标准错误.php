<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/3/5
 * Time: 上午11:17
 */

/**
 *
 * 标准输入、标准输出、标准错误输出
 *
 *
 * php中有三个默认打开的文件句柄 STDIN，STDOUT, STDERR 分别对应上述三个文件描述符，
 * 而由于标准输入输出是和终端相关的，对于守护进程来说并没有什么用，可以直接关闭，但是直接关闭可能会造成一个问题，请看下面这段代码
 */



fclose(STDOUT);

$fp = fopen("/tmp/stdout.log", "a");

echo "hello world\n";


/**
 * 运行上述代码时，屏幕不会输出echo的信息，而是写入到打开的文件中了，
 * 这是由于关闭STDOUT文件句柄后，释放了对应的文件描述符，而linux打开文件总是使用最小的可用文件描述符，
 * 所以这个文件描述符现在指向fopen打开的文件了，导致原本写到标准输出的信息现在写到了文件里。
 * 为了避免这种怪异的行为，我们在关闭这三个文件句柄之后可以立即打开 linux提供的黑洞文件 /dev/null，比如：
 */



fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
fopen('/dev/null', 'r');
fopen('/dev/null', 'w');
fopen('/dev/null', 'w');

$fp = fopen("/tmp/stdout.log", "a");

echo "hello world\n";


/**
 *
 * 上面这个例程关闭STDIN，STDOUT, STDERR立马打开 /dev/null 三次，这样echo的信息会直接写到黑洞中，避免了前面出现的怪异的问题。
 */