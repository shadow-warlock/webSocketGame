<?php

namespace WebSocketGame\Model\Inventory;

use JsonSerializable;

class Inventory implements JsonSerializable
{
    private $items = [];

    public function addItem(InventoryItem $newItem){
        foreach ($this->checkNewItem($newItem) as $item) {
            if ($newItem->getQuantity() > 0) {
                if (($item->getQuantity() + $newItem->getQuantity()) <= $item->getMaxQuantity()) {
                    $item->changeQuantity($newItem->getQuantity());
                    return;
                } else {
                    $newItem->changeQuantity(-($item->getMaxQuantity() - $item->getQuantity()));
                    $item->changeQuantity($item->getMaxQuantity() - $item->getQuantity());
                }
            }
            else return;
        }
        $this->items[] = $newItem;
    }

    public function jsonSerialize() {
        return $this->items;
    }

    public function checkNewItem(InventoryItem $newItem) {
        $notFullItems = [];
        foreach ($this->items as $item) {
            if (($item->getName() == $newItem->getName()) && ($item->getQuantity() < $item->getMaxQuantity())){
                $notFullItems[] = $item;
            }
        }
        return $notFullItems;
    }

    public function getItems(): array
    {
        return $this->items;
    }


}
