<?php 

class User
{


    //database connection + table name
    private $conn;
    private $table_name = "users";

    //user DB properties 
    public $name;
    public $privileges;
    public $createdAccount;
    public $clockedIn;
    public $userID;
    public $badgeID;
    public $totalShifts;

    //constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function newUser($name, $privledges = 0, $badgeID = null)
    {
        $query = "INSERT INTO users (name,privileges,badgeID)VALUES(:name,:privledges,:badgeID)";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':privledges', $privledges);
        $stmt->bindParam(':badgeID', $badgeID);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // public function findUser(){}

    // public function deleteUser(){}

}


?>