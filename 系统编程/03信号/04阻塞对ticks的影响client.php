<?php
/**
 * Created by PhpStorm.
 * User: yaok
 * Date: 2019/12/31
 * Time: 上午9:44
 */

$client_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_connect($client_socket,'127.0.0.1',8888);