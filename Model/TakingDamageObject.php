<?php


namespace WebSocketGame\Model;


use WebSocketGame\Model\Loot\LootBox;

class TakingDamageObject extends GameObject{
    protected $maxHp;
    protected $hp;
    protected $lootBox;
    protected $givesExp;
    public const ALIVE = "alive";
    public const DEAD = "dead";

    public function __construct($name, $x, $y, $radius, $hp, $lootBox, $givesExp){
        parent::__construct($name, $x, $y, $radius);
        $this->maxHp=$hp;
        $this->givesExp = $givesExp;
        $this->hp=$hp;
        $this->lootBox = $lootBox;
    }

    public function jsonSerialize() {
        return array_merge(parent::jsonSerialize(),[
            "maxHp" => $this->maxHp,
            "hp" => $this->hp]);
    }

    public function takingDamage($damage) {
        if ($this->hp>$damage){
            $this->hp = $this->hp-$damage;
            return self::ALIVE;
        }
        else {
            $this->hp = 0;
            return self::DEAD;
        }
    }

    public function droppingLoot(){
        foreach ($this->lootBox->generatingLoot() as $lootItem) {
             $loot[] = [
                 "item" => $lootItem["item"],
                 "x" => $this->coordinates["x"],
                 "y" => $this->coordinates["y"],
                 "radius" => $this->radius,
                 "quantity" =>$lootItem["quantity"]];
        }
        return $loot;
    }

    public function getHp(): int{
        return $this->hp;
    }
}
