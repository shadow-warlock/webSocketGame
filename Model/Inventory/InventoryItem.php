<?php

namespace WebSocketGame\Model\Inventory;

class InventoryItem
{
    private $name;
    private $quantity;


    public function __construct($name, $quantity) {
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function getItem()
    {
        return ["name" => $this->name, "quantity" => $this->quantity];
    }
}