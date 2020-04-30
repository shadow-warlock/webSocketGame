<?php


namespace WebSocketGame;

class User
{
    private $connection;
    private $coordinates = [];
    private $color;

    public function __construct()
    {
        $this->coordinates=[rand(0,10000), rand(0,10000)];
}
}
