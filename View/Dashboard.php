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
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css">
    </head>
    <body>
        <?php
            echo "<h1>Dashboard</h1>";
            echo "Welcome ".$_SESSION["name"]."<br>";
            echo "Role: ".$_SESSION["role"]."<br>";

            if($_SESSION["role"]=="admin")
                {
                    echo "Admin Panel Access <br><br>";
                    echo "<table border='1'>";
                    echo "<tr>";
                    echo "<td><a href='AdminSellerRequests.php'>Seller Requests</a></td>";
                    echo "<td><a href='CategoryManage.php'>Category Manage</a></td>";
                    echo "<td><a href='AdminDashboard.php'>Admin Dashboard</a></td>";                   
                    echo "<td><a href='../Controller/Logout.php'>Logout</a></td>";
                    echo "</tr>";
                    echo "</table>";
                }
                else{
                    if($_SESSION["seller_verified"]==1)
                        {
                            echo "Seller Status: Verified Seller <br>";
                        }
                        else{
                            echo "Seller Status: Buyer / Not Verified Seller <br>";
                        }
        ?>
        <br>
        <table border="1">
            <tr>
                <td><a href="Profile.php">Profile</a></td>
                <td><a href="BecomeSeller.php">Become Seller</a></td>
                <td><a href="BrowseAuctions.php">Browse Auctions</a></td>
                <td><a href="../Controller/Logout.php">Logout</a></td>
            </tr>
            <?php
            if($_SESSION["seller_verified"]==1)
                {
                    echo "<tr>";
                    echo "<td><a href='CreateListing.php'>Create Listing</a></td>";
                    echo "<td><a href='SellerDashboard.php'>Seller Dashboard</a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
                }
        ?>
    </body>
</html>
