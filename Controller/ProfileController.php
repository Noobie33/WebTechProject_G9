<?php
include "../Model/db.php";
session_start();

$name="";
$email="";
$phone="";
$bio="";
$role="";
$seller_verified="";
$nameErr="";
$phoneErr="";
$message="";

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        Header("Location:../View/Login.php");
    }

$database = new db();
$connection = $database->connection();
$userResult = $database->UserInfo($connection,"users",$_SESSION["user_id"]);

if($userResult->num_rows==1)
    {
        while($row=$userResult->fetch_assoc())
            {
                $name=$row["name"];
                $email=$row["email"];
                $phone=$row["phone"];
                $bio=$row["bio"];
                $role=$row["role"];
                $seller_verified=$row["seller_verified"];
            }
    }

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name = trim($_POST["name"]);
        $phone = trim($_POST["phone"]);
        $bio = trim($_POST["bio"]);

        if(empty($name))
            {
                $nameErr="Name Required";
            }
        else if(strlen($name)<3)
            {
                $nameErr="Name must be at least 3 characters";
            }
        else if(is_numeric($name))
            {
                $nameErr="Name can't be numeric value";
            }

        if(empty($phone))
            {
                $phoneErr="Phone Required";
            }
        else if(!preg_match("/^[0-9]+$/",$phone))
            {
                $phoneErr="Phone must contain only numbers";
            }

        if(empty($nameErr) && empty($phoneErr))
            {
                $checkPhone = $database->CheckPhoneForUpdate($connection,"users",$phone,$_SESSION["user_id"]);

            if($checkPhone->num_rows>0)
                {
                    $phoneErr="Phone Already Taken";
                }
                else{
                $result = $database->UpdateProfile($connection,"users",$_SESSION["user_id"],$name,$phone,$bio);

                if($result)
                    {
                        $_SESSION["name"]=$name;
                        $message="Profile Updated Successfully";
                    }
                    else{
                        $message="Profile Update Failed";
                    }
                }
            }
    }
?>
