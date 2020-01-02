<?php
/**
 * Created by PhpStorm.
 * User: yaokun
 * Date: 2019/3/8
 * Time: 下午9:46
 */


/**
 * 构造函数 __construct
 *
 * Worker::__construct([string $listen , array $context])
 *
 * 初始化一个Worker容器实例，可以设置容器的一些属性和回调接口，完成特定功能。
 *
 *
 * 参数
 *      ->$listen （可选参数，不填写表示不监听任何端口）
 *        如果有设置监听$listen参数，则会执行socket监听。
 *        $listen 的格式为 <协议>://<监听地址>
 *
 * <协议> 可以为以下格式：
tcp: 例如 tcp://0.0.0.0:8686

udp: 例如 udp://0.0.0.0:8686

unix: 例如 unix:///tmp/my_file(需要Workerman>=3.2.7)

http: 例如 http://0.0.0.0:80

websocket: 例如 websocket://0.0.0.0:8686

text: 例如 text://0.0.0.0:8686(text是Workerman内置的文本协议，兼容telnet，详情参见附录Text协议部分)

以及其他自定义协议，参见本手册定制通讯协议部分
 *
 *
 *
 *
 * <监听地址> 可以为以下格式：
 * 如果是unix套接字，地址为本地一个磁盘路径
 * 非unix套接字，地址格式为 <本机ip>:<端口号>
 *
<本机ip>可以为0.0.0.0表示监听本机所有网卡，包括内网ip和外网ip及本地回环127.0.0.1

<本机ip>如果以为127.0.0.1表示监听本地回环，只能本机访问，外部无法访问

<本机ip>如果为内网ip，类似192.168.xx.xx，表示只监听内网ip，则外网用户无法访问

<本机ip>设置的值不属于本机ip则无法执行监听，并且提示Cannot assign requested address错误
 *
 *
 * 注意：<端口号>不能大于65535。<端口号>如果小于1024则需要root权限才能监听。
 * 监听的端口必须是本机未被占用的端口，否则无法监听，并且提示Address already in use错误
 *
 *
 *
 *      ->$context
 *        一个数组。用于传递socket的上下文选项
 */