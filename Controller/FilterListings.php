<?php
include "../Model/db.php";
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        echo json_encode(array());
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);

$category_id = isset($_GET["category_id"]) ? intval($_GET["category_id"]) : 0;

if($category_id > 0)
    {
        $result = $database->FilterListingsByCategory($connection, $category_id);
    }
else
    {
        $result = $database->ShowActiveListings($connection);
    }

$listings = array();
while($row = $result->fetch_assoc())
    {
        $listings[] = array(
            "id"=>$row["id"],
            "title"=>$row["title"],
            "current_bid"=>$row["current_bid"],
            "bid_count"=>$row["bid_count"],
            "category_name"=>$row["category_name"],
            "end_datetime"=>$row["end_datetime"],
            "image_path"=>$row["image_path"]
        );
    }
echo json_encode($listings);
?>
