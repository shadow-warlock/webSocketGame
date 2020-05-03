<?php

namespace WebSocketGame;

use JsonSerializable;

class User implements JsonSerializable {

    private $connection;
    private $login;
    private $coordinates = [
        "x" => 0,
        "y" => 0,
    ];
    public const RADIUS = 20;
    public const MELEE_RADIUS = 50;
    private $color = [
        "r" => 0,
        "g" => 0,
        "b" => 0,
    ];
    private $hp;
    private $exp;
    private $damage = [];
    private $lastMove = 0;

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
        $this->damage=[10,20];
    }

    public function jsonSerialize() {
        return [
            "login" => $this->login,
            "coordinates" => $this->coordinates,
            "radius" => self::RADIUS,
            "meleeRadius" => self::MELEE_RADIUS,
            "color" => $this->color,
            "hp" => $this->hp,
            "exp" => $this->exp,
            "damage"=> $this->damage];
    }

    public function move($x,$y): void
    {
        $currentTime = (int) (microtime(true) * 1000);
        if($currentTime - $this->lastMove < 50){
            echo "net";
            return;
        }
        $this->lastMove = $currentTime;
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

    public function meleeRadiusCheck($x,$y): bool{
        return Utilities::radiusCheck($x,$this->getCoordinates()["x"],$y,$this->getCoordinates()["y"],self::MELEE_RADIUS);
    }

    public function radiusCheck($x,$y): bool{
        return Utilities::radiusCheck($x,$this->getCoordinates()["x"],$y,$this->getCoordinates()["y"],self::RADIUS);
    }

    public function takindDamage($damage){
        if ($this->hp>$damage){
            $this->hp = $this->hp-$damage;
        }
        else
            $this->hp = 0;
    }

    public function generatingDamage(): int{
        return rand($this->damage[0],$this->damage[1]);
    }

    public function getLogin() {
        return $this->login;
    }
    public function getConnection(){
        return $this->connection;
    }
    public function getCoordinates(): array{
        return $this->coordinates;
    }
    public function getColor(): array{
        return $this->color;
    }
    public function getHp(): int{
        return $this->hp;
    }
    public function getExp(): int{
        return $this->exp;
    }
}
