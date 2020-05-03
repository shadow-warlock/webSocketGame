<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Utilities.php';

use WebSocketGame\User;
use WebSocketGame\Utilities;
use Workerman\Timer;
use Workerman\Worker;

$users = [];

$ws_worker = new Worker("websocket://0.0.0.0:8000");
$ws_worker->onWorkerStart = function () use (&$users) {
    Timer::add(0.1, function() use   (&$users){
        $data = ["type" => "users", "data" => $users];
        foreach ($users as $user) {
            $user->getConnection()->send(json_encode($data));
        }
    });
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

$ws_worker->onMessage = function ($connection, $data) use (&$users) {
    $data = json_decode($data, true);
    if ($data["type"]==="move") {
        foreach ($users as $user) {
            if ($user->getConnection() === $connection) {
                $user->move($data["data"]["horizontal"]*5,$data["data"]["vertical"]*5);
            }
        }
    }
    if ($data["type"]==="melee") {
        foreach ($users as $attacking) {
            if ($attacking->getConnection() === $connection) {
                if ($attacking->meleeRadiusCheck($data["data"]["x"],$data["data"]["y"])) {
                        foreach ($users as $attacked) {
                            if ($attacked->radiusCheck($data["data"]["x"],$data["data"]["y"])) {
                                $attacked->takindDamage($attacking->generationDamage());
                            }
                    }
                }
                $user->move($data["data"]["horizontal"]*5,$data["data"]["vertical"]*5);
            }
        }
    }
};

$ws_worker->onConnect = function ($connection) use (&$users) {
    $connection->onWebSocketConnect = function ($connection) use (&$users) {
        $users[$_GET['user']] = new User($connection, $_GET['user']);
    };
};

$ws_worker->onClose = function ($connection) use (&$users) {
    // удаляем параметр при отключении пользователя
    $user = array_search($connection, $users);
    unset($users[$user]);
};

// Run worker
Worker::runAll();
