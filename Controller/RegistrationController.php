<?php
include "../Model/db.php";
session_start();

$name = "";
$email="";
$phone="";
$bio="";
$password="";
$confirm_password="";

$nameErr="";
$emailErr="";
$phoneErr="";
$passwordErr="";
$confirmPasswordErr="";
$message="";

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true)
    {
        Header("Location:../View/Dashboard.php");
    }

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name = trim($_POST["name"] ?? "");
         $email = trim($_POST["email"] ?? "");
        $phone = trim($_POST["phone"] ?? "");
    $bio = trim($_POST["bio"] ?? "");
    $password= $_POST["password"] ?? "";
    $confirm_password= $_POST["confirm_password"] ?? "";
        if(empty($name))
            {
                $nameErr="Name Required";
            }
        else if(strlen($name)<3)
            {
                $nameErr="Name must be at least 3 characters";
            }

        if(empty($email))
            {
                $emailErr="Email Required";
            }
        else if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$email))
            {
                $emailErr="Invalid Email";
            }

        if(empty($phone))
    {
        $phoneErr="Phone Required";
    }
else if(!preg_match("/^[0-9]+$/",$phone))
    {
        $phoneErr="Phone must contain only numbers";
    }

        if(empty($password))
            {
                $passwordErr="Password Required";
            }
        else if(strlen($password)<8)
            {
                $passwordErr="Password must be at least 8 characters";
            }

        if(empty($confirm_password))
            {
                $confirmPasswordErr="Confirm Password Required";
            }
        else if($password!=$confirm_password)
            {
                $confirmPasswordErr="Password Not Matched";
            }

        if(empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($passwordErr) && empty($confirmPasswordErr))
            {
                $database = new db();
                $connection = $database->connection();

                $check = $database->CheckEmail($connection,"users",$email);

                if($check->num_rows>0)
                    {
                        $emailErr="Email Already Taken";
                    }
                    else{
                        $password_hash=password_hash($password,PASSWORD_DEFAULT);
                        $result = $database->signup($connection,"users", $name, $email, $phone, $bio, $password_hash);

                        if($result)
                            {
                                $_SESSION["success"]="Registration Successful. Please Login.";
                                Header("Location:../View/Login.php");
                            }
                            else{
                                $message="Registration Failed";
                            }
                    }
            }
    }
?>
