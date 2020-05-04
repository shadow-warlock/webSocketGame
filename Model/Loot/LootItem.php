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


}
