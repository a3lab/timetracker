<?php

//want to switch from GET to POST data
//getting errors when doing so... not sure 
//why

//currently assuming that all input is safe

// need to double check on these lines
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//get our required files
define('__ROOT__', __DIR__ . '/');
require_once(__ROOT__ . 'database.php');
require_once(__ROOT__ . 'user.php');
require_once(__ROOT__ . 'helperFunctions.php');

//we need to check for a command
//if we have a command we then need to check
//if we have all of the required arguments to 
//run the given command
//if all is okay we can run the command and return
//the data

if (isset($_GET['command']) && !empty($_GET['command'])) {

    //get ready to run a command
    $database = new Database();
    $db = $database->getConnection();

    //clock command this will clock in and out
    if (strcmp($_GET['command'], "clock") == 0) {
        if (isset($_GET['badgeID']) && !empty($_GET['badgeID'])) {

            //now we need to clock in that user


            echo json_encode(
                array(
                    "query" => "running",
                    "message" => "need a badgeID to clock in or out"
                )
            );
        } else {
            echo json_encode(
                array(
                    "query" => "nothing run",
                    "message" => "need a badgeID to clock in or out"
                )
            );
        }

    } else if (strcmp($_GET['command'], "newUser") == 0) {
        if (isset($_GET['userName']) && !empty($_GET['userName']) && isset($_GET['badgeID']) && !empty($_GET['badgeID'])) {
            //valiadate badge & name
            if (validateName($_GET['userName']) && validateBadge($_GET['badgeID'])) {
                $user = new User($db);
                $user->newUser($_GET['userName'], $_GET['badgeID']);
            } else {
                echo json_encode(
                    array(
                        "query" => "nothing run",
                        "message" => "invalid name or badgeID"
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "query" => "nothing run",
                    "message" => "need a name and badgeID to make a user"
                )
            );
        }
    } else {
        echo json_encode(
            array(
                "query" => "nothing run",
                "message" => "not a recognised command"
            )
        );
    }
} else {
    echo json_encode(
        array(
            "query" => "nothing run",
            "message" => "give a command"
        )
    );
}

?>