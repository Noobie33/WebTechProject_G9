<?php
include "../Model/db.php";
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true || $_SESSION["role"]!="admin")
    {
        echo json_encode(array("ok"=>false,"message"=>"Unauthorized"));
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);

echo json_encode(array("ok"=>true,"message"=>"Expired auctions closed"));
?>
