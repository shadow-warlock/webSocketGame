<?php

namespace WebSocketGame\Model;

use WebSocketGame\Model\Loot\LootBox;
use WebSocketGame\Utilities;

class User extends TakingDamageObject{

    private $connection;
    private $login;
    public $meleeRadius;
    private $exp;
    private $damage = [];
    private $lastMove = 0;
    private $lastAttack = 0;
    public const COOLDOWN = 1000;

    public function __construct($connection, $login, $x, $y){
        parent::__construct("user", $x, $y,20, 100, new LootBox());
        $this->connection=$connection;
        $this->login=$login;
        $this->meleeRadius=50;
        $this->exp=0;
        $this->damage=[100,200];
    }

    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(), [
            "login" => $this->login,
            "meleeRadius" => $this->meleeRadius,
            "exp" => $this->exp,
            "damage" => $this->damage,
            "lastAttack" => $this->lastAttack,
            "cooldown" => self::COOLDOWN]);
    }

    public function move($x,$y): void{
        $currentTime = (int) (microtime(true) * 1000);
        if($currentTime - $this->lastMove < 50){
            return;
        }
        $this->lastMove = $currentTime;
        $this->coordinates["x"] = $this->coordinates["x"]+$x;
        $this->coordinates["y"] = $this->coordinates["y"]+$y;
    }

    public function meleeRadiusCheck($x,$y): bool{
        return Utilities::radiusCheck($x,$this->getCoordinates()["x"],$y,$this->getCoordinates()["y"],$this->meleeRadius);
    }

    public function dealingDamage(TakingDamageObject $attacked){
        $currentTime = (int) (microtime(true) * 1000);
        if($currentTime - $this->lastAttack < self::COOLDOWN){
            return TakingDamageObject::ALIVE;
        }
        $this->lastAttack = $currentTime;
        return $attacked->takingDamage($this->generatingDamage());
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
