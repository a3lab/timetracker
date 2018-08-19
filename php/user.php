<?php 

require_once(__ROOT__ . 'helperFunctions.php');
class User
{
    //database connection + table name
    private $conn;
    private $tableName = "users";

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
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 1) {

            $userArray = array();
            $userArray["user"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);
        
                //this allows us to rename anything we need to
                $usersItem = array(
                    "userID" => $userID,
                    "badgeID" => $badgeID,
                    "name" => $name,
                    "privileges" => $privileges,
                    "atOffice" => ($clockedIn ? true : false),
                    "totalShifts" => $totalShifts,
                    "createdAccount" => $createdAccount
                );
                array_push($userArray["user"], $usersItem);
            }

            echo json_encode(
                $userArray
            );

        } else {
            echo json_encode(
                array(
                    "query" => "success",
                    "message" => "No users found"
                )
            );
        }
    }


    function newUser($name, $badgeID = null, $privledges = 0)
    {
        $query = "INSERT INTO " . $this->tableName . " (name,privileges,badgeID)VALUES(:name,:privledges,:badgeID)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':privledges', $privledges);
        $stmt->bindParam(':badgeID', $badgeID);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {

            echo json_encode(
                array(
                    "query" => "success",
                    "message" => "account created"
                )
            );
        } else {
            echo json_encode(
                array(
                    "query" => "failure",
                    "message" => "unknown failure. contact matt"
                )
            );
        }
    }

    function findUserByBadgeID($badgeID)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE badgeID = :badgeID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':badgeID', $badgeID);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            echo json_encode(
                array(
                    "user" => $stmt->fetch(PDO::FETCH_ASSOC),
                    "query" => "success",
                    "message" => "success"
                )
            );
        } else if ($stmt->rowCount() > 1) {
            echo json_encode(
                array(
                    "query" => "failure",
                    "message" => "unexpected error. Please contact matt"
                )
            );
        } else {
            echo json_encode(
                array(
                    "query" => "success",
                    "message" => "no users found"
                )
            );
        }
    }

    function setClock()
    {
        //check if the user is clocked in

    }

    public function deleteUser()
    {
    }

    public function updateUser()
    {
    }
}


?>