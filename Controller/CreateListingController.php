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

$title = "";
$description = "";
$category_id = "";
$starting_price = "";
$reserve_price = "";
$end_datetime = "";

$titleErr = "";
$descErr = "";
$catErr = "";
$priceErr = "";
$reserveErr = "";
$endErr = "";
$imageErr = "";
$message = "";

$categories = $database->ShowCategory($connection);

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $title = trim($_POST["title"]);
        $description = trim($_POST["description"]);
        $category_id = $_POST["category_id"];
        $starting_price = $_POST["starting_price"];
        $reserve_price = trim($_POST["reserve_price"]);
        $end_datetime = trim($_POST["end_datetime"]);

        if(empty($title)){ $titleErr = "Title required"; }
        if(empty($description)){ $descErr = "Description required"; }
        if(empty($category_id)){ $catErr = "Please select a category"; }

        if(empty($starting_price) || !is_numeric($starting_price) || $starting_price <= 0)
            {
                $priceErr = "Starting price must be a positive number";
            }

        if(!empty($reserve_price))
            {
                if(!is_numeric($reserve_price) || $reserve_price < $starting_price)
                    {
                        $reserveErr = "Reserve price must be >= starting price";
                    }
            }

        if(empty($end_datetime))
            {
                $endErr = "End date and time required";
            }
        else
            {
                $endTs = strtotime($end_datetime);
                if($endTs < time() + 3600)
                    {
                        $endErr = "End time must be at least 1 hour from now";
                    }
            }

        $image_path = "";
        if(isset($_FILES["image"]) && $_FILES["image"]["error"]==0)
            {
                $allowedTypes = array("image/jpeg","image/jpg","image/png");
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES["image"]["tmp_name"]);
                finfo_close($finfo);

                if(!in_array($mimeType, $allowedTypes))
                    {
                        $imageErr = "Only JPEG/PNG images allowed";
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

        if(empty($titleErr) && empty($descErr) && empty($catErr) && empty($priceErr) && empty($reserveErr) && empty($endErr) && empty($imageErr))
            {
                $sp = floatval($starting_price);
                $rp = !empty($reserve_price) ? floatval($reserve_price) : null;
                $result = $database->CreateListing($connection, $_SESSION["user_id"], $category_id, $title, $description, $sp, $rp, $image_path, $end_datetime);
                if($result)
                    {
                        $_SESSION["success"] = "Listing created successfully";
                        Header("Location:../View/SellerDashboard.php");
                        exit;
                    }
                else
                    {
                        $message = "Failed to create listing";
                    }
            }
    }
?>
