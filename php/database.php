<?php

// need to double check on these lines
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Still need to do input sanitation


//rowCount() only works on DELETE, INSERT, and UPDATE
// http://php.net/manual/en/pdostatement.rowcount.php

class Database{

    public $conn;

    function __construct() {
        
        require_once('credentials.php');
        $this -> host = $host;
        $this -> db_name = $db_name;
        $this -> username = $username;
        $this -> password = $password;
    }

    // get the database connection
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function newUser($name,$privledges=0,$badgeID=NULL){
        $query = "INSERT INTO users (name,privileges,badgeID)VALUES(:name,:privledges,:badgeID)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':privledges', $privledges);
        $stmt->bindParam(':badgeID', $badgeID);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllUsers(){
        $query = "SELECT * FROM users";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findUser(){}

    public function deleteUser(){}

    //function for when a user swipes their RFID card
    //this will call either the clockin or the clock out record
    public function useClock(){
        //fetch user id based on the RFID tag
    
        //if user with that id is clocked in clock them out 

            //search for most recent record in the records table and set the clock out time

        //else
            //set clocked in to true

            //create new time record
    }

    private function clockIn(){}

    private function clockOut(){}
}



$n = new Database();

$n->newUser("matthew Loewen 3",3,1231231231231);




?>