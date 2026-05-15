<?php
include "../Model/db.php";
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        Header("Location:../View/Login.php");
        exit;
    }
if($_SESSION["seller_verified"]!=1)
    {
        Header("Location:../View/Dashboard.php");
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);

$sellerListings = $database->GetSellerResults($connection, $_SESSION["user_id"]);

$successMsg = "";
if(isset($_SESSION["success"]))
    {
        $successMsg = $_SESSION["success"];
        unset($_SESSION["success"]);
    }
?>
