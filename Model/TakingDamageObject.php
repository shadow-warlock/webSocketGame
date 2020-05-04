<?php


namespace WebSocketGame\Model;


class TakingDamageObject extends GameObject{
    protected $maxHp;
    protected  $hp;
    protected $lootBox;

    public function __construct($name, $x, $y, $radius, $hp, $lootBox){
        parent::__construct($name, $x, $y, $radius);
        $this->maxHp=$hp;
        $this->hp=$hp;
        $this->lootBox = $lootBox;
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
