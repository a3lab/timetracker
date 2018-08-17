<?php

//our "API" works based on sent POST data

//currently assuming that all input is safe

// need to double check on these lines
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//get our required files
define('__ROOT__', __DIR__ . '/');
require_once(__ROOT__ . 'database.php');
require_once(__ROOT__ . 'user.php');


$database = new Database();
$db = $database->getConnection();

$user = new user($db);

$stmt = $user->getAllUsers();
$num = $stmt->rowCount();

if ($num > 0) {

    $user_array = array();
    $user_array["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $usersItem = array(
            "userID" => $userID,
            "badgeID" => $badgeID,
            "name" => $name,
            "privileges" => $privileges,
            "clockedIn" => $clockedIn,
            "totalShifts" => $totalShifts,
            "createdAccount" => $createdAccount
        );
        array_push($user_array["records"], $usersItem);
    }

    echo json_encode($user_array);


} else {
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>