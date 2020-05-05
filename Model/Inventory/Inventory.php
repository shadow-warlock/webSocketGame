<?php

namespace WebSocketGame\Model\Inventory;

use JsonSerializable;

class Inventory implements JsonSerializable
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
            if (($item->getName() == $newItem->getName()) && ($item->getQuantity() < $item->getMaxQuantity())){
                $item->addQuantity($newItem->getQuantity());
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
