<?php
include "../Model/db.php";
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true || $_SESSION["role"]!="admin")
    {
        Header("Location:../View/Login.php");
    }

$database = new db();
$connection = $database->connection();
$result = $database->PendingSellerRequest($connection);
?>
