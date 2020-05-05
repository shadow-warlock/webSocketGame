<?php

namespace WebSocketGame\Model\Inventory;

use JsonSerializable;
use WebSocketGame\Model\DroppedObject;
use WebSocketGame\Model\User;

class InventoryItem implements JsonSerializable
{
    private $name;
    private $quantity;
    private $maxQuantity;
    private $isUsed;
    private $effects = [];
    private $useCount;


    public function __construct(DroppedObject $droppedObject, $isUsed, array $effects = [], $useCount = 0) {
        $this->name = $droppedObject->getName();
        $this->quantity = $droppedObject->getQuantity();
        $this->maxQuantity = $droppedObject->getMaxQuantity();
        $this->isUsed = $isUsed;
        $this->effects = $effects;
        $this->useCount = $useCount;
    }


    public function use(User $user){
        if($this->isUsed && $this->useCount <= $this->quantity){
            foreach($this->effects as $effect){
                $parameter = $effect->getParameter();
                $user->$parameter(...$effect->getValues());
            }
            $this->quantity -= $this->useCount;
        }
        return $this->isUsed && $this->useCount <= $this->quantity;
    }

    public function jsonSerialize() {
        return $this->getItem();
    }

    public function getName() {
        return $this->name;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function changeQuantity($added) {
        $this->quantity += $added;
    }

    public function getMaxQuantity()
    {
        return $this->maxQuantity;
    }

    public function getItem()
    {
        return [
            "name" => $this->name,
            "quantity" => $this->quantity,
            "maxQuantity" => $this->maxQuantity,
            "isUsed" => $this->isUsed,
            "effects" => $this->effects,
            "useCount" => $this->useCount
        ];
    }
}
