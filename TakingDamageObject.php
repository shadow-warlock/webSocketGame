<?php


namespace WebSocketGame;

class TakingDamageObject extends GameObject{
    protected $maxHp;
    protected  $hp;

    public function __construct($name, $radius, $hp, $x, $y){
        parent::__construct($name, $radius, $x, $y);
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
        else
            $this->hp = 0;
    }

    public function getHp(): int{
        return $this->hp;
    }
}