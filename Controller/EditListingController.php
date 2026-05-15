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

$listing_id = isset($_GET["id"]) ? intval($_GET["id"]) : (isset($_POST["listing_id"]) ? intval($_POST["listing_id"]) : 0);

if($listing_id==0)
    {
        Header("Location:../View/SellerDashboard.php");
        exit;
    }

$listingResult = $database->GetListingById($connection, $listing_id);
if($listingResult->num_rows==0)
    {
        Header("Location:../View/SellerDashboard.php");
        exit;
    }
$listing = $listingResult->fetch_assoc();

if($listing["seller_id"]!=$_SESSION["user_id"])
    {
        Header("Location:../View/SellerDashboard.php");
        exit;
    }

$bid_count = $database->CountBidsByListing($connection, $listing_id);
$can_edit = ($bid_count==0 && $listing["status"]=="active");

$title = $listing["title"];
$description = $listing["description"];
$titleErr = "";
$descErr = "";
$imageErr = "";
$message = "";

if($_SERVER["REQUEST_METHOD"]=="POST" && $can_edit)
    {
        $title = trim($_POST["title"]);
        $description = trim($_POST["description"]);

        if(empty($title)){ $titleErr = "Title required"; }
        if(empty($description)){ $descErr = "Description required"; }

        $image_path = null;
        if(isset($_FILES["image"]) && $_FILES["image"]["error"]==0)
            {
                $allowedTypes = array("image/jpeg","image/jpg","image/png");
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES["image"]["tmp_name"]);
                finfo_close($finfo);
                if(!in_array($mimeType, $allowedTypes))
                    {
                        $imageErr = "Only JPEG/PNG allowed";
                    }
                else if($_FILES["image"]["size"] > 3*1024*1024)
                    {
                        $imageErr = "Image must be under 3MB";
                    }
                else
                    {
                        $uploadDir = "../File/listings/";
                        $filename = uniqid()."_".$_FILES["image"]["name"];
                        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir.$filename);
                        $image_path = "File/listings/".$filename;
                    }
            }

        if(empty($titleErr) && empty($descErr) && empty($imageErr))
            {
                $result = $database->UpdateListing($connection, $listing_id, $title, $description, $image_path);
                if($result)
                    {
                        $message = "Listing updated successfully";
                        $listingResult = $database->GetListingById($connection, $listing_id);
                        $listing = $listingResult->fetch_assoc();
                    }
                else
                    {
                        $message = "Update failed";
                    }
            }
    }
?>
