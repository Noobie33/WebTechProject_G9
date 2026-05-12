<?php
include "../Model/db.php";
session_start();

$motivation="";
$motivationErr="";
$message="";
$requestStatus="";
$requestMotivation="";

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        Header("Location:../View/Login.php");
    }

$database = new db();
$connection = $database->connection();

$checkRequest = $database->CheckSellerRequest($connection,"seller_requests",$_SESSION["user_id"]);
if($checkRequest->num_rows==1)
    {
        while($row=$checkRequest->fetch_assoc())
            {
                $requestStatus=$row["status"];
                $requestMotivation=$row["motivation"];
            }
    }

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $motivation = $_POST["motivation"] ?? "";

        if($_SESSION["seller_verified"]==1)
            {
                $message="You are already a verified seller";
            }
        else if(!empty($requestStatus) && $requestStatus=="pending")
            {
                $message="Your seller request is already pending";
            }
        else{
                if(empty($motivation))
                    {
                        $motivationErr="Motivation Required";
                    }
                else if(strlen($motivation)<20)
                    {
                        $motivationErr="Motivation must be at least 20 characters";
                    }

                if(empty($motivationErr))
                    {
                        $result = $database->SellerRequest($connection,"seller_requests",$_SESSION["user_id"],$motivation);

                        if($result)
                            {
                                $message="Seller Request Submitted Successfully";
                                $requestStatus="pending";
                                $requestMotivation=$motivation;
                            }
                            else{
                                $message="Seller Request Failed";
                            }
                    }
            }
    }
?>
