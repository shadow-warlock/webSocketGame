<?php

namespace WebSocketGame;

use JsonSerializable;

class User extends GameObject implements JsonSerializable {

    private $connection;
    private $login;
    public $meleeRadius;
    private $exp;
    private $damage = [];
    private $lastMove = 0;
    private $lastAttack = 0;
    public const COOLDOWN = 1000;

    public function __construct($connection, $login){
        parent::__construct(20, rand(0,255), rand(0,255), rand(0,255), 100);
        $this->connection=$connection;
        $this->login=$login;
        $this->meleeRadius=50;
        $this->exp=0;
        $this->damage=[10,20];
    }

    public function jsonSerialize() {
        return [
            "login" => $this->login,
            "coordinates" => $this->coordinates,
            "radius" => $this->radius,
            "meleeRadius" => $this->meleeRadius,
            "color" => $this->color,
            "maxHp" => $this->maxHp,
            "hp" => $this->hp,
            "exp" => $this->exp,
            "damage" => $this->damage,
            "lastAttack" => $this->lastAttack,
            "cooldown" => self::COOLDOWN];
    }

    public function move($x,$y): void{
        $currentTime = (int) (microtime(true) * 1000);
        if($currentTime - $this->lastMove < 50){
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
        return Utilities::radiusCheck($x,$this->getCoordinates()["x"],$y,$this->getCoordinates()["y"],$this->meleeRadius);
    }

    public function dealingDamage(User $attacked): void{
        $currentTime = (int) (microtime(true) * 1000);
        if($currentTime - $this->lastAttack < self::COOLDOWN){
            return;
        }
        $attacked->takingDamage($this->generatingDamage());
        $this->lastAttack = $currentTime;
    }

    public function generatingDamage(): int{
        return rand($this->damage[0],$this->damage[1]);
    }

    public function getLogin(){
        return $this->login;
    }
    public function getConnection(){
        return $this->connection;
    }
    public function getColor(): array{
        return $this->color;
    }
    public function getExp(): int{
        return $this->exp;
    }
}
