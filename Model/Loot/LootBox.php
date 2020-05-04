<?php


namespace WebSocketGame\Model\Loot;


class LootBox
{

    private $items = [];

    public function __construct()
    {

    }

    public function addItem(LootItem $item){
        $this->items[] = $item;
    }
}
