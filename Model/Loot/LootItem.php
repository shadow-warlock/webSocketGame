<?php


namespace WebSocketGame\Model\Loot;


class LootItem
{
    private $item;
    private $chance;
    private $qualities = [];


    public function __construct($item, $chance, array $qualities) {
        $this->item = $item;
        $this->chance = $chance;
        $this->qualities = $qualities;
    }

    public function generatingLoot() {
        if (rand(0,100) < $this->chance*100) {
            return ["item" => $this->item, "quantity" => rand($this->qualities[0], $this->qualities[1])];
        }
        return null;
    }
}
