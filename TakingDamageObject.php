<?php


namespace WebSocketGame;

class TakingDamageObject extends GameObject{
    protected $maxHp;
    protected  $hp;
    protected $loot;
    protected $lootQuantity = [];

    public function __construct($name, $x, $y, $radius, $hp){
        parent::__construct($name, $x, $y, $radius);
        $this->maxHp=$hp;
        $this->hp=$hp;
    }

    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(),[
            "maxHp" => $this->maxHp,
            "hp" => $this->hp]);
    }

    public function takingDamage($damage): void{
        if ($this->hp>$damage){
            $this->hp = $this->hp-$damage;
        }
        else {
            $this->hp = 0;
        }
    }

    public function getHp(): int{
        return $this->hp;
    }
}