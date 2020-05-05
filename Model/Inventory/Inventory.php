<?php

namespace WebSocketGame\Model\Inventory;

class Inventory
{
    private $items = [];

    public function addItem(InventoryItem $newItem){
        if ($this->checkNewItem($newItem)){
            $this->items[] = $newItem;
        }
    }

    public function jsonSerialize() {
        return $this->items;
    }

    public function checkNewItem(InventoryItem $newItem): bool {
        foreach ($this->items as $item) {
            if ($item["name"] == $newItem["name"]){
                $item["quantity"] = $item["quantity"] + $newItem["uantity"];
                return false;
            }
        }
        return true;
    }

    public function getItems(): array
    {
        return $this->items;
    }


}