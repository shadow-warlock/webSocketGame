<?php


namespace WebSocketGame\Factory;


use WebSocketGame\Model\DroppedObject;
use WebSocketGame\Model\Inventory\Effect;
use WebSocketGame\Model\Inventory\InventoryItem;
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
            $this->droppedObjects[$objName] = $data;
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

    public function generateInventoryItem(DroppedObject $object){
        $droppedInfo = $this->droppedObjects[$object->getName()];
        $isUsed = isset($droppedInfo["use"]);
        if($isUsed){
            $useCount = $droppedInfo["use"]["count"];
            $effects = [];
            foreach($droppedInfo["use"]["effects"] as $parameter => $value){
                $effects[] = new Effect($parameter, $value);
            }
            return new InventoryItem($object, $isUsed, $effects, $useCount);
        }
        return new InventoryItem($object, $isUsed);
    }
}
