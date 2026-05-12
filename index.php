<?php
session_start();

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true)
    {
        if($_SESSION["role"]=="admin")
            {
                Header("Location:View/AdminSellerRequests.php");
            }
            else{
                Header("Location:View/Dashboard.php");
            }
    }
    else{
        Header("Location:View/Login.php");
    }
?>
