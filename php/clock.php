<?php

class Clock
{
    //database connection + table name
    private $conn;
    private $table_name = "records";

    // DB properties 
    public $recordID;
    public $userID;
    public $timeIn;
    public $timeOut;

    //constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }




}

?>