<?php
include "../Model/db.php";
session_start();

$email="";
$password="";
$emailErr="";
$passwordErr="";
$message="";

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true)
    {
        if($_SESSION["role"]=="admin")
            {
                Header("Location:../View/AdminSellerRequests.php");
            }
            else{
                Header("Location:../View/Dashboard.php");
            }
    }

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $email = $_POST["email"] ?? "";
        $password= $_POST["password"] ?? "";

        if(empty($email))
            {
                $emailErr="Email Required";
            }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $emailErr="Invalid Email";
            }

        if(empty($password))
            {
                $passwordErr="Password Required";
            }

        if(empty($emailErr) && empty($passwordErr))
            {
                $database = new db();
                $connection = $database->connection();
                $result = $database->signin($connection,"users", $email);

                if($result->num_rows==1)
                    {
                        while($row=$result->fetch_assoc())
                            {
                                if(password_verify($password,$row["password_hash"]))
                                    {
                                        $_SESSION["id"]=$row["id"];
                                        $_SESSION["user_id"]=$row["id"];
                                        $_SESSION["name"]=$row["name"];
                                        $_SESSION["email"]=$row["email"];
                                        $_SESSION["role"]=$row["role"];
                                        $_SESSION["seller_verified"]=$row["seller_verified"];
                                        $_SESSION["loggedIn"]=true;

                                        if($row["role"]=="admin")
                                            {
                                                Header("Location:../View/AdminSellerRequests.php");
                                            }
                                            else{
                                                Header("Location:../View/Dashboard.php");
                                            }
                                    }
                                    else{
                                        $message="Invalid Email or Password";
                                    }
                            }
                    }
                    else{
                        $message="Invalid Email or Password";
                    }
            }
    }
?>
