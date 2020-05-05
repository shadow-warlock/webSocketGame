<?php


namespace WebSocketGame\Model;


use WebSocketGame\Model\Loot\LootBox;

class TakingDamageObject extends GameObject{
    protected $maxHp;
    protected $hp;
    protected LootBox $lootBox;
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
        return array_map(function ($item){return array_merge($item, $this->generatedDroppedCoordinates());}, $this->lootBox->generatingLoot());
    }

    protected function generatedDroppedCoordinates(){
        return [
            "x" => rand($this->coordinates["x"] - $this->radius, $this->coordinates["x"] + $this->radius),
            "y" => rand($this->coordinates["y"] - $this->radius, $this->coordinates["y"] + $this->radius),
        ];
    }

    public function getHp(): int{
        return $this->hp;
    }
}
