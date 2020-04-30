<?php


namespace WebSocketGame;

class User
{
    private $connection;
    private $coordinates = [];
    private $color = [
        "R"  => 0,
        "G" => 0,
        "B" => 0,
    ];
    private $hp;
    private $exp;

    public function __construct($connection)
    {
        $this->connection=$connection;
        $this->coordinates=[rand(0,1000), rand(0,1000)];
        $this->color["R"]=rand(0,255);
        $this->color["G"]=rand(0,255);
        $this->color["B"]=rand(0,255);
        $this->hp=100;
        $this->exp=0;
    }

    public function getConnection()
    {
        return $this->connection;
    }
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }
    public function getColor(): array
    {
        return $this->color;
    }
    public function getHp(): array
    {
        return $this->hp;
    }
    public function getExp(): array
    {
        return $this->exp;
    }
}
