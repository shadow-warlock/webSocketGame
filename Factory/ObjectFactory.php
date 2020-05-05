<?php


namespace WebSocketGame\Factory;


use WebSocketGame\Model\DroppedObject;
use WebSocketGame\Model\Loot\LootBox;
use WebSocketGame\Model\Loot\LootItem;
use WebSocketGame\Model\TakingDamageObject;
use WebSocketGame\Utilities;

class ObjectFactory {

    private $damagedObjects = [];
    private $droppedObjects = [];

    public function __construct() {
        $json = file_get_contents(__DIR__ . "/../config/DamagedObjects.json");
        $config = json_decode($json, true);
        foreach($config as $objName => $data){
            $lootBox = new LootBox();
            foreach($data["lootBox"] as $lootName => $loot){
                $lootItem = new LootItem($lootName, $loot["chance"], $loot["quantities"]);
                $lootBox->addItem($lootItem);
            }
            $this->damagedObjects[$objName] = [
                'radius' => $data['radius'],
                'givesExp' => $data['givesExp'],
                "hp" => $data['hp'],
                "lootBox" => $lootBox
            ];
        }
        $json = file_get_contents(__DIR__ . "/../config/DroppedObjects.json");
        $config = json_decode($json, true);
        foreach($config as $objName => $data){
            $this->droppedObjects[$objName] = [
                'radius' => $data['radius'],
                'maxQuantity' => $data['maxQuantity'],
            ];
        }
    }

    public function create($name, $x, $y){
        if(isset($this->damagedObjects[$name])){
            $data = $this->damagedObjects[$name];
            return new TakingDamageObject($name, $x, $y, $data['radius'], $data['hp'], $data["lootBox"], $data["givesExp"]);
        }
        return null;
    }

    public function createDropped($name, $x, $y, $radius, $quantity){
        if(isset($this->droppedObjects[$name])){
            $data = $this->droppedObjects[$name];
            $maxQuantity = $data['maxQuantity']/10;
            while ($quantity > $maxQuantity){
                $coordinates = Utilities::generatedDroppedCoordinates($x, $y, $radius);
                $objects[] = new DroppedObject($name, $coordinates["x"], $coordinates["y"],$data['radius'], $data['maxQuantity'], $maxQuantity);
                $quantity = $quantity-$maxQuantity;
            }
            if ($quantity > 0){
                $objects[] = new DroppedObject($name, $x, $y, $data['radius'], $data['maxQuantity'], $quantity);
            }
            return $objects;
        }
        return null;
    }
}
