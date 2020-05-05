<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/autoload.php';

use WebSocketGame\Model\User;
use WebSocketGame\Validator\BaseValidator;
use WebSocketGame\World;
use Workerman\Timer;
use Workerman\Worker;

$world = new World();

$ws_worker = new Worker("websocket://0.0.0.0:8000");
$ws_worker->onWorkerStart = function () use (&$world) {

    Timer::add(0.05, function() use  (&$world){
        $data = json_encode(["type" => "world", "data" => $world, "time" => (int) (microtime(true) * 1000)]);
        foreach ($world->getUsers() as $user) {
            $user->getConnection()->send($data);
        }
    });
};

$ws_worker->onMessage = function ($connection, $data) use (&$world) {
    $data = json_decode($data, true);
    $user = $world->findUserByConnection($connection);
    if(BaseValidator::validateUser($user)){
        return;
    }
    if ($data["type"]==="move") {
        $horizontal = $data["data"]["horizontal"] * 3;
        $vertical = $data["data"]["vertical"] * 3;
        $world->moveUser($user, $horizontal, $vertical);
        return;
    }
    if($data["type"] === "melee") {
        $world->melee($user, $data["data"]["x"], $data["data"]["y"]);
    }
};

$ws_worker->onConnect = function ($connection) use (&$world) {
    $connection->onWebSocketConnect = function ($connection) use (&$world) {
        $world->addUser($connection, $_GET['user']);
    };
};

$ws_worker->onClose = function ($connection) use (&$world) {
    // удаляем параметр при отключении пользователя
    $user = $world->findUserByConnection($connection);
    $world->removeUser($user);
};

// Run worker
Worker::runAll();
