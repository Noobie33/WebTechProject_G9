<?php
include "../Controller/SellerRequestController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css">
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

        <form method = "post" action="BecomeSeller.php">
            <h1>Seller Verification Request</h1>
            <?php
            echo "<span class='message'>".$message."</span><br><br>";

            if($_SESSION["seller_verified"]==1)
                {
                    echo "You are already a verified seller";
                }
            else if($requestStatus=="pending")
                {
                    echo "Your seller request is pending <br>";
                    echo "Motivation: ".$requestMotivation;
                }
            else{
            ?>
            <table>
                <tr>
                    <td>Motivation: </td>
                    <td><textarea name="motivation" placeholder="Write why you want to become a seller"><?php echo $motivation ?></textarea> <span class="error"><?php echo $motivationErr ?></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Submit Request"></td>
                </tr>
            </table>
            <?php
            }
            ?>
        </form>
    </body>
</html>
