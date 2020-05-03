<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Utilities.php';

use WebSocketGame\User;
use Workerman\Timer;
use Workerman\Worker;

$users = [];
$ws_worker = new Worker("websocket://0.0.0.0:8000");
$ws_worker->onWorkerStart = function() use (&$users) {
    Timer::add(0.02, function() use (&$users) {
        $data = json_encode(["type" => "users", "data" => array_values($users), "time" => (int)(microtime(true) * 1000)]);
        foreach($users as $user) {
            $user->getConnection()->send($data);
        }
    });
};

$ws_worker->onMessage = function($connection, $data) use (&$users) {
    $data = json_decode($data, true);
    if($data["type"] === "move") {
        foreach($users as $user) {
            if($user->getConnection() === $connection) {
                $user->move($data["data"]["horizontal"] * 3, $data["data"]["vertical"] * 3);
            }
        }
    }
    if($data["type"] === "melee") {
        foreach($users as $attacking) {
            if($attacking->getConnection() === $connection) {
                if($attacking->meleeRadiusCheck($data["data"]["x"], $data["data"]["y"])) {
                    foreach($users as $attacked) {
                        if($attacked->radiusCheck($data["data"]["x"], $data["data"]["y"])) {
                            $attacking->dealingDamage($attacked);
                        }
                    }
                }
            }
        }
    }
};

$ws_worker->onConnect = function($connection) use (&$users) {
    $connection->onWebSocketConnect = function($connection) use (&$users) {
        $users[$_GET['user']] = new User($connection, $_GET['user']);
    };
};

$ws_worker->onClose = function($connection) use (&$users) {
    // удаляем параметр при отключении пользователя
    $user = array_search($connection, $users);
    unset($users[$user]);
};

// Run worker
Worker::runAll();
