<?php

class connectDB
{
    public $conn;
    private $hostName = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbName = "db_npshop";

    function __construct()
    {
        $this->conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
    }
}
