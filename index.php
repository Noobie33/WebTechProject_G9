<?php
session_start();

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true)
    {
        Header("Location:View/Dashboard.php");
    }
    else{
        Header("Location:View/Login.php");
    }
?>
