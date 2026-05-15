<?php
include "../Model/db.php";
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true || $_SESSION["seller_verified"]!=1)
    {
        echo json_encode(array("ok"=>false,"message"=>"Unauthorized"));
        exit;
    }

$listing_id = $_POST["listing_id"]??0;
$database = new db();
$connection = $database->connection();

$listingResult = $database->GetListingById($connection, $listing_id);
if($listingResult->num_rows==0)
    {
        echo json_encode(array("ok"=>false,"message"=>"Listing not found"));
        exit;
    }
$listing = $listingResult->fetch_assoc();

if($listing["seller_id"]!=$_SESSION["user_id"])
    {
        echo json_encode(array("ok"=>false,"message"=>"Unauthorized"));
        exit;
    }

$bid_count = $database->CountBidsByListing($connection, $listing_id);
if($bid_count > 0)
    {
        echo json_encode(array("ok"=>false,"message"=>"Cannot cancel: listing has bids"));
        exit;
    }

$result = $database->CancelListing($connection, $listing_id);
if($result){ echo json_encode(array("ok"=>true,"message"=>"Listing cancelled")); }
else{ echo json_encode(array("ok"=>false,"message"=>"Cancel failed")); }
?>
