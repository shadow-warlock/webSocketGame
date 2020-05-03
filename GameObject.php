<?php


namespace WebSocketGame;


class GameObject{
    protected $coordinates = [
        "x" => 0,
        "y" => 0,
    ];
    protected $color = [
        "r" => 0,
        "g" => 0,
        "b" => 0,
    ];
    protected $radius;
    protected $maxHp;
    protected  $hp;

    public function __construct($radius,$r, $g, $b, $hp){
        $this->coordinates["x"]=rand(0,1000);
        $this->coordinates["y"]=rand(0,1000);
        $this->radius=$radius;
        $this->color["r"]=$r;
        $this->color["g"]=$g;
        $this->color["b"]=$b;
        $this->maxHp=$hp;
        $this->hp=$hp;
    }

    public function takingDamage($damage): void{
        if ($this->hp>$damage){
            $this->hp = $this->hp-$damage;
        }
        else
            $this->hp = 0;
    }

    public function radiusCheck($x,$y): bool{
        return Utilities::radiusCheck($x,$this->getCoordinates()["x"],$y,$this->getCoordinates()["y"],$this->radius);
    }

    public function getCoordinates(): array{
        return $this->coordinates;
    }
    public function getHp(): int{
        return $this->hp;
    }
}