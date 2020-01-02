<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/2/25
 * Time: 下午3:51
 */

#初始化Smarty类库的默认设置
/**
 * file: init.inc.php
 * smarty对象的实例化 及 初始化文件
 */

define('ROOT',dirname(__FILE__).'/');
require ROOT.'libs/Smarty.class.php';
$smarty = new Smarty();

//推荐使用Smarty3 以上版本方式设置默认路径，成功后返回$smarty对象本身，可连贯操作
$smarty->setTemplateDir(ROOT.'templates/');
$smarty->setCompileDir(ROOT.'templates_c/');
$smarty->setPluginsDir(ROOT.'plugins/');
$smarty->setCacheDir(ROOT.'cache/');
$smarty->setConfigDir(ROOT.'configs/');

//设置 Smarty 缓存开关功能
$smarty->caching = false;
$smarty->cache_lifetime = 60*60*24;//一天


//分界符
$smarty->left_delimiter = '<{';
$smarty->right_delimiter = '}>';