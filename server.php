<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/autoload.php';

use WebSocketGame\User;
use WebSocketGame\World;
use Workerman\Timer;
use Workerman\Worker;

$world = new World;

$ws_worker = new Worker("websocket://0.0.0.0:8000");
$ws_worker->onWorkerStart = function () use (&$world) {

    Timer::add(0.02, function() use  (&$world){
        $data = json_encode(["type" => "world", "data" => $world, "time" => (int) (microtime(true) * 1000)]);
        foreach ($world->getUsers() as $user) {
            $user->getConnection()->send($data);
        }
    });

    for ($i=0;$i<5;$i++){
        $world->addDamagedObject("stone", 50, 200);
    };
};

$ws_worker->onMessage = function ($connection, $data) use (&$world) {
    $data = json_decode($data, true);
    if ($data["type"]==="move") {
        $user=$world->findUserByConnection($connection);
        $user->move($data["data"]["horizontal"]*3,$data["data"]["vertical"]*3);
        return;
    }
    if($data["type"] === "melee") {
        $attacking = $world->findUserByConnection($connection);
        if ($attacking->meleeRadiusCheck($data["data"]["x"], $data["data"]["y"])) {
            foreach ($world->mergeObject() as $attacked) {
                if ($attacking !== $attacked && $attacked->radiusCheck($data["data"]["x"], $data["data"]["y"])) {
                    $attacking->dealingDamage($attacked);
                    return;
                }
            }
        }
    }
};

$ws_worker->onConnect = function ($connection) use (&$world) {
    $connection->onWebSocketConnect = function ($connection) use (&$world) {
        $world->addUser($connection, $_GET['user']);
    };
    $connection->onClose = function($connection) use (&$world)
    {
        // удаляем параметр при отключении пользователя
        $user = array_search($connection, array_map(function(User $user){return $user->getConnection();}, $world->getUsers()));
        echo $user;
        $world->removeUser($user);
    };
};

$ws_worker->onClose = function ($connection) use (&$world) {
};

// Run worker
Worker::runAll();
