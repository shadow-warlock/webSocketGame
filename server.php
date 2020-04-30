<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/User.php';

use WebSocketGame\User;
use Workerman\Worker;

$users = [];

$ws_worker = new Worker("websocket://0.0.0.0:8000");
$ws_worker->onWorkerStart = function() use (&$users)
{
//    // создаём локальный tcp-сервер, чтобы отправлять на него сообщения из кода нашего сайта
//    $inner_tcp_worker = new Worker("tcp://127.0.0.1:1234");
//    // создаём обработчик сообщений, который будет срабатывать,
//    // когда на локальный tcp-сокет приходит сообщение
//    $inner_tcp_worker->onMessage = function($connection, $data) use (&$users) {
//        $data = json_decode($data);
//        // отправляем сообщение пользователю по userId
//        if (isset($users[$data->user])) {
//            $webconnection = $users[$data->user];
//            $webconnection->send($data->message);
//        }
//    };
//    $inner_tcp_worker->listen();
};

$ws_worker->onMessage = function($connection, $data) use (&$users){
    $data = json_decode($data, true);
    $user = array_search($connection, $users);
    $connection2 = $users[$data['user']];
    $connection2->send(json_encode(["type"=>"message", "author"=>$user, "data" => $data['text']]));
    $connection->send(json_encode(["type"=>"message", "author"=>$user, "data" => $data['text']]));

};

$ws_worker->onConnect = function($connection) use (&$users)
{
    $connection->onWebSocketConnect = function($connection) use (&$users)
    {
        $users[$_GET['user']] = new User($connection);
        print_r($users);
        $data = ["type" => "users", "data" => array_keys($users)];
        foreach($users as $user){
            $user->getConnection()->send(json_encode($data));
        }
    };
};

$ws_worker->onClose = function($connection) use(&$users)
{
    // удаляем параметр при отключении пользователя
    $user = array_search($connection, $users);
    unset($users[$user]);
    $data = ["type" => "users", "data" => array_keys($users)];
    foreach($users as $connection){
        $connection->send(json_encode($data));
    }
};

// Run worker
Worker::runAll();
