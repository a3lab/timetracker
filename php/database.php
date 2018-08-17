<?php

class Database
{

    public $conn;

    function __construct()
    {

        require_once('credentials.php');
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
    }

    // get the database connection
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
    //function for when a user swipes their RFID card
    //this will call either the clockin or the clock out record
    public function useClock()
    {
        //fetch user id based on the RFID tag
    
        //if user with that id is clocked in clock them out 

            //search for most recent record in the records table and set the clock out time

        //else
            //set clocked in to true

            //create new time record
    }

    private function clockIn()
    {
    }

    private function clockOut()
    {
    }
}

?>