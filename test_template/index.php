<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/2/25
 * Time: 上午10:49
 */
include_once './MySmarty.php';

$name = 'haha';

$my_smarty = new MySmarty();
$my_smarty->assign('name',$name);
$my_smarty->display('index.html');