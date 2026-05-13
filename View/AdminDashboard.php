<?php
session_start();
$isloggedIn=$_SESSION["loggedIn"] ?? false;
if(!$isloggedIn)
    {
        Header("Location:Login.php"); 
    }
if($_SESSION["role"]!="admin")
    {
        Header("Location:Dashboard.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css">
    </head>
    <body>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="AdminSellerRequests.php">Seller Requests</a>
            <a href="CategoryManage.php">Category Manage</a>
            <a href="AdminDashboard.php">Analytics</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>

        <div class="box">
            <?php
                echo "<h1>Analytics</h1>";
                echo "This page will be completed in Task 4.";
            ?>
        </div>
    </body>
</html>
