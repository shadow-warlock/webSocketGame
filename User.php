<?php


namespace WebSocketGame;

class User
{
    private $connection;
    private $coordinates = [];
    private $color = [
        "R"  => 0,
        "G" => 0,
        "B" => 0,
    ];

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection): void
    {
        $this->connection = $connection;
    }

    public function __construct($connection)
    {
        $this->connection=$connection;
        $this->coordinates=[rand(0,1000), rand(0,1000)];
        $this->color["R"]=rand(0,255);
        $this->color["G"]=rand(0,255);
        $this->color["B"]=rand(0,255);
}
}
