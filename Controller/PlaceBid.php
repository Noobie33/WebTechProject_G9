<?php
include "../Model/db.php";
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        echo json_encode(array("ok"=>false,"message"=>"Please login"));
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);

$listing_id = $_POST["listing_id"]??0;
$amount = $_POST["amount"]??0;

$auctionResult = $database->GetAuctionDetails($connection, $listing_id);
if($auctionResult->num_rows==0)
    {
        echo json_encode(array("ok"=>false,"message"=>"Auction not found"));
        exit;
    }
$auction = $auctionResult->fetch_assoc();

if($auction["status"]!="active")
    {
        echo json_encode(array("ok"=>false,"message"=>"Auction is not active"));
        exit;
    }
if(strtotime($auction["end_datetime"]) <= time())
    {
        echo json_encode(array("ok"=>false,"message"=>"Auction has expired"));
        exit;
    }
if($auction["seller_id"]==$_SESSION["user_id"])
    {
        echo json_encode(array("ok"=>false,"message"=>"You cannot bid on your own listing"));
        exit;
    }
if($amount <= $auction["current_bid"])
    {
        echo json_encode(array("ok"=>false,"message"=>"Bid must be greater than current bid of $".$auction["current_bid"]));
        exit;
    }

$result = $database->PlaceBid($connection, $listing_id, $_SESSION["user_id"], $amount);
if($result)
    {
        $database->UpdateCurrentBid($connection, $listing_id, $amount);
        $bid_count = $database->GetBidCount($connection, $listing_id);
        echo json_encode(array(
            "ok"=>true,
            "new_bid"=>floatval($amount),
            "bid_count"=>$bid_count,
            "bidder_name"=>$_SESSION["name"],
            "bid_time"=>date("Y-m-d H:i:s")
        ));
    }
else
    {
        echo json_encode(array("ok"=>false,"message"=>"Failed to place bid"));
    }
?>
