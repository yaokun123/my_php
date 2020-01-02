<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/2/25
 * Time: 下午4:14
 */

//第一个 Smarty 的简单示例

require './init.inc.php';

$smarty->assign('title','测试用的网页标题');
$smarty->assign('content',"测试用的网页内容");

$smarty->display('test.html');