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
require_once(__ROOT__ . 'helperFunctions.php');


$database = new Database();
$db = $database->getConnection();

$user = new user($db);

$stmt = $user->getAllUsers();

// $stmt = $user->newUser("30");



?>