<?php


namespace WebSocketGame\Model\Loot;


class LootItem
{
    private $item;
    private $chance;
    private $quantities = [];


    public function __construct($item, $chance, array $quantities) {
        $this->item = $item;
        $this->chance = $chance;
        $this->quantities = $quantities;
    }

    public function generatingLoot() {
        if (rand(0,100) < $this->chance*100) {
            return ["item" => $this->item, "quantity" => rand($this->quantities[0], $this->quantities[1])];
        }
        return null;
    }
}
