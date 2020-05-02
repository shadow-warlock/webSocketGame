<?php


namespace WebSocketGame;

class User
{
    private $connection;
    private $login;
    private $coordinates = [
        "x" => 0,
        "y" => 0,
    ];
    private $color = [
        "r" => 0,
        "g" => 0,
        "b" => 0,
    ];
    private $hp;
    private $exp;

    public function __construct($connection, $login)
    {
        $this->connection=$connection;
        $this->login=$login;
        $this->coordinates["x"]=rand(0,1000);
        $this->coordinates["y"]=rand(0,1000);
        $this->color["r"]=rand(0,255);
        $this->color["g"]=rand(0,255);
        $this->color["b"]=rand(0,255);
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
    public function getHp(): int
    {
        return $this->hp;
    }
    public function getExp(): int
    {
        return $this->exp;
    }
    public function move($x,$y): void
    {
        $this->coordinates["x"] = $this->coordinates["x"]+$x;
        $this->coordinates["y"] = $this->coordinates["y"]+$y;
        if($this->coordinates["x"] < 0){
            $this->coordinates["x"] = 1000 + $this->coordinates["x"];
        }
        if($this->coordinates["x"] > 1000){
            $this->coordinates["x"] = 0 + $this->coordinates["x"]%1000;
        }
        if($this->coordinates["y"] < 0){
            $this->coordinates["y"] = 1000 + $this->coordinates["y"];
        }
        if($this->coordinates["y"] > 1000){
            $this->coordinates["y"] = 0 + $this->coordinates["y"]%1000;
        }
    }

    /**
     * @return mixed
     */
    public function getLogin() {
        return $this->login;
    }



}
