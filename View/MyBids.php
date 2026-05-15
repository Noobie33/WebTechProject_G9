<?php
include "../Controller/MyBidsController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
    </head>
    <body>
        <?php
        if($_SESSION["seller_verified"]==1)
            {
        ?>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="Profile.php">Profile</a>
            <a href="BrowseAuctions.php">Browse Auctions</a>
            <a href="MyBids.php">My Bids</a>
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
            <a href="MyBids.php">My Bids</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>
        <?php
            }
        ?>

        <div class="box">
            <h1>My Bids</h1>
            <table border="1" class="data-table">
                <tr>
                    <td>Auction Title</td>
                    <td>My Highest Bid</td>
                    <td>Current/Final Bid</td>
                    <td>Status</td>
                    
                </tr>
                <?php
                if($myBids && $myBids->num_rows>0)
                    {
                        while($row = $myBids->fetch_assoc())
                            {
                                $myBid = floatval($row['my_highest_bid']);
                                $currentBid = floatval($row['current_bid']);
                                $isActive = ($row['status']=='active' && strtotime($row['end_datetime']) > time());
                                

                                $badge = "";
                                

                                if($isActive)
                                    {
                                        if($myBid==$currentBid)
                                            {
                                                $badge = "<span style='color:green;font-weight:bold'>Leading</span>";
                                            }
                                        else
                                            {
                                                $badge = "<span style='color:orange;font-weight:bold'>Outbid</span>";
                                            }
                                    }
                                
                                
                                else
                                    {
                                        $badge = "<span style='color:#888'>".ucfirst($row['status'])."</span>";
                                    }

                                echo "<tr>";
                                echo "<td><a href='AuctionDetails.php?id=".$row['listing_id']."'>".htmlspecialchars($row['title'])."</a></td>";
                                echo "<td>$".number_format($myBid,2)."</td>";
                                echo "<td>$".number_format($currentBid,2)."</td>";
                                echo "<td>".$badge."</td>";
                                echo "</tr>";
                            }
                    }
                else
                    {
                        echo "<tr><td colspan='4'>You have not placed any bids yet. <a href='BrowseAuctions.php'>Browse Auctions</a></td></tr>";
                    }
                ?>
            </table>
        </div>
    </body> 
</html>