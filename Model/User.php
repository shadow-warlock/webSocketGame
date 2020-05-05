<?php

namespace WebSocketGame\Model;

use WebSocketGame\Model\Inventory\Inventory;
use WebSocketGame\Model\Inventory\InventoryItem;
use WebSocketGame\Model\Loot\LootBox;
use WebSocketGame\Model\Loot\LootItem;
use WebSocketGame\Utilities;

class User extends TakingDamageObject{

    private $connection;
    private $login;
    public $meleeRadius;
    private $exp;
    private $damage = [];
    private Inventory $inventory;
    private $lastMove = 0;
    private $lastAttack = 0;
    public const COOLDOWN = 1000;

    public function __construct($connection, $login, $x, $y){
        $lootBox = new LootBox();
        $lootBox->addItem(new LootItem("gold", 0.9, [3,30]));
        $inventory = new Inventory();
        parent::__construct("User", $x, $y,20, 100, new LootBox(), 100);
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
            "inventory" => $this->inventory,
            "lastAttack" => $this->lastAttack,
            "cooldown" => self::COOLDOWN]);
    }

    public function takingObject ($name, $quantity){
        $this->inventory->addItem(new InventoryItem($name, $quantity));
    }

    public function move($x,$y): void{
        $currentTime = (int) (microtime(true) * 1000);
        if($currentTime - $this->lastMove < 50){
            return;
        }
        $this->lastMove = $currentTime;
        $this->coordinates["x"] = intval($this->coordinates["x"]+ $x * (1 + $this->exp/100));
        $this->coordinates["y"] = intval($this->coordinates["y"] + $y * (1 + $this->exp/100));
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
        $isDead = $attacked->takingDamage($this->generatingDamage());
        if($isDead == self::DEAD){
            $this->addExp($attacked->givesExp);
        }
        return $isDead;
    }

    public function addExp($exp){
        $this->exp += $exp;
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
