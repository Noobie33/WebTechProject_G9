<?php
session_start();
$isloggedIn=$_SESSION["loggedIn"] ?? false;
if(!$isloggedIn)
    {
        Header("Location:Login.php"); 
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css?v=10">
    </head>
    <body>
        <?php
        if($_SESSION["role"]=="admin")
            {
        ?>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="AdminSellerRequests.php">Seller Requests</a>
            <a href="CategoryManage.php">Category Manage</a>
            <a href="AdminDashboard.php">Analytics</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>
        <?php
            }
        else if($_SESSION["seller_verified"]==1)
            {
        ?>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="Profile.php">Profile</a>
            <a href="BrowseAuctions.php">Browse Auctions</a>
            <a href="CreateListing.php">Create Listing</a>
            <a href="SellerDashboard.php">Seller Dashboard</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>
        <?php
            }
        else{
        ?>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="Profile.php">Profile</a>
            <a href="BecomeSeller.php">Become Seller</a>
            <a href="BrowseAuctions.php">Browse Auctions</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>
        <?php
            }
        ?>

        <div class="box">
            <?php
                echo "<h1>Create Auction Listing</h1>";
                echo "This page will be completed in Task 2.";
            ?>
        </div>
    </body>
</html>
