<?php


namespace WebSocketGame\Factory;


use WebSocketGame\Model\Loot\LootBox;
use WebSocketGame\Model\Loot\LootItem;
use WebSocketGame\Model\TakingDamageObject;

class ObjectFactory {
    public function create($name, $x, $y){
        switch($name){
            case "Stone":
                $lootBox = new LootBox();
                $lootBox->addItem(new LootItem("stone", 1.0, [3, 10]));
                return new TakingDamageObject($name, $x, $y, 50, 200, $lootBox);
        }
        return null;
    }
}
