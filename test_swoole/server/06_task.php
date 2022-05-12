<?php

$server = new swoole_server("127.0.0.1", 9501);

//设置异步任务的工作进程数量
$server->set(array('task_worker_num' => 4));


$server->on('receive', function($serv, $fd, $from_id, $data) {
    $task_id = $serv->task($data);  // 投递异步任务
    echo "Dispath AsyncTask: id=$task_id".PHP_EOL;
});

//处理异步任务
$server->on('task', function ($serv, $task_id, $from_id, $data) {
    echo "New AsyncTask[id=$task_id]".PHP_EOL;
    $serv->finish("$data -> OK");   //返回任务执行的结果
});

//处理异步任务的结果
$server->on('finish', function ($serv, $task_id, $data) {
    echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
});

$server->start();