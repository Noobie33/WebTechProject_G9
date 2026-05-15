<?php
include "../Model/db.php";
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        Header("Location:../View/Login.php");
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);

$listing_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if($listing_id==0)
    {
        Header("Location:../View/BrowseAuctions.php");
        exit;
    }

$auctionResult = $database->GetAuctionDetails($connection, $listing_id);
if($auctionResult->num_rows==0)
    {
        Header("Location:../View/BrowseAuctions.php");
        exit;
    }
$auction = $auctionResult->fetch_assoc();
$bids = $database->GetLastTenBids($connection, $listing_id);
$bid_count = $database->GetBidCount($connection, $listing_id);

$winner_info = null;
if($auction["status"]=="ended" && $auction["winner_bid_id"])
    {
        $winnerResult = $database->GetWinnerInfo($connection, $auction["winner_bid_id"]);
        if($winnerResult->num_rows > 0){ $winner_info = $winnerResult->fetch_assoc(); }
    }
?>
