<?php

namespace WebSocketGame\Model\Inventory;

use JsonSerializable;

class InventoryItem implements JsonSerializable
{
    private $name;
    private $quantity;


    public function __construct($name, $quantity) {
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function jsonSerialize() {
        return $this->getItem();
    }

    public function getName() {
        return $this->name;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function addQuantity($added) {
        $this->quantity += $added;
    }



    public function getItem()
    {
        return ["name" => $this->name, "quantity" => $this->quantity];
    }
}
