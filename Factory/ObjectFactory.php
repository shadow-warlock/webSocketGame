<?php


namespace WebSocketGame\Factory;


use WebSocketGame\Model\Loot\LootBox;
use WebSocketGame\Model\Loot\LootItem;
use WebSocketGame\Model\TakingDamageObject;

class ObjectFactory {
    public function create($type, $x, $y){
        switch($type){
            case "Stone":
                $lootBox = new LootBox();
                $lootBox->addItem(new LootItem("Stone", 0.5, [1, 10]));
                return new TakingDamageObject($type, $x, $y, 50, 200, $lootBox);
                break;
        }
        return null;
    }
}
