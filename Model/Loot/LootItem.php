<?php


namespace WebSocketGame\Model\Loot;


class LootItem
{
    private $name;
    private $chance;
    private $quantities = [];


    public function __construct($name, $chance, array $quantities) {
        $this->name = $name;
        $this->chance = $chance;
        $this->quantities = $quantities;
    }

    public function generatingLoot() {
        if (rand(0,100) < $this->chance*100) {
            return ["item" => $this->name, "quantity" => rand($this->quantities[0], $this->quantities[1])];
        }
        return null;
    }
}
