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
        Header("Location:../View/Dashboard.php");
    }

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $email = trim($_POST["email"] ?? "");
        $password= $_POST["password"] ?? "";

        if(empty($email))
            {
                $emailErr="Email Required";
            }
        else if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$email))
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

                                        Header("Location:../View/Dashboard.php");
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
