<?php


namespace WebSocketGame\Model\Loot;


class LootBox
{
    private $items = [];

    public function addItem(LootItem $item){
        $this->items[] = $item;
    }

    public function generatingLoot() {
        $realLoot = [];
        foreach ($this->items as $item){
            $realLootItem = $item->generatingLoot();
            if ($realLootItem != null){
                $realLoot[] = $realLootItem;
            }
        }
        return $realLoot;
    }
}
