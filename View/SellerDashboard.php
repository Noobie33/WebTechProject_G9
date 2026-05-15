<?php
include "../Controller/SellerDashboardController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src="../Controller/JS/ListingCountdown.js"></Script>
        <Script src="../Controller/JS/ListingActions.js"></Script>
    </head>
    <body>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="Profile.php">Profile</a>
            <a href="BrowseAuctions.php">Browse Auctions</a>
            <a href="MyBids.php">My Bids</a>
            <a href="CreateListing.php">Create Listing</a>
            <a href="SellerDashboard.php">Seller Dashboard</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>

        <div class="box">
            <h1>Seller Dashboard</h1>
            <?php if($successMsg!=""){ echo "<span class='message'>".$successMsg."</span><br><br>"; } ?>
            <p><a href="CreateListing.php"><input type="button" value="+ Create New Listing"></a></p>

            <table border="1" class="data-table">
                <tr>
                    <td>Title</td>
                    <td>Category</td>
                    <td>Starting Price</td>
                    <td>Current Bid</td>
                    <td>Reserve</td>
                    <td>Bids</td>
                    <td>Status</td>
                    <td>Time Remaining</td>
                    <td>Winner / Result</td>
                    <td>Actions</td>
                </tr>
                <?php
                if($sellerListings && $sellerListings->num_rows>0)
                    {
                        $rowNum = 1;
                        while($row = $sellerListings->fetch_assoc())
                            {
                                $isActive = ($row['status']=='active' && strtotime($row['end_datetime']) > time());
                                $isEnded = ($row['status']=='ended');
                                $reserveMet = (!$row['reserve_price'] || $row['current_bid'] >= $row['reserve_price']);

                                echo "<tr>";
                                echo "<td>".htmlspecialchars($row['title'])."</td>";
                                echo "<td>".$row['category_name']."</td>";
                                echo "<td>$".number_format($row['starting_price'],2)."</td>";
                                echo "<td>$".number_format($row['current_bid'],2)."</td>";
                                echo "<td>".($row['reserve_price'] ? "$".number_format($row['reserve_price'],2) : "None")."</td>";
                                echo "<td>".$row['bid_count']."</td>";
                                echo "<td id='status".$rowNum."'>";
                                if($row['status']=='active' && $isActive){ echo "<span style='color:green'>Active</span>"; }
                                else if($row['status']=='ended'){ echo "<span style='color:#555'>Ended</span>"; }
                                else if($row['status']=='cancelled'){ echo "<span style='color:orange'>Cancelled</span>"; }
                                else{ echo "<span style='color:red'>Expired</span>"; }
                                echo "</td>";
                                echo "<td>";
                                if($isActive){ echo "<span data-end='".$row['end_datetime']."'></span>"; }
                                else{ echo "---"; }
                                echo "</td>";
                                echo "<td>";
                                if($isEnded)
                                    {
                                        if($row['winner_bid_id'] && $row['winner_name'])
                                            {
                                                if($reserveMet)
                                                    {
                                                        echo "<b style='color:green'>Sold</b><br>";
                                                        echo "Amount: $".number_format($row['winning_amount'],2)."<br>";
                                                        echo "Winner: ".$row['winner_name']."<br>";
                                                        echo "Email: ".$row['winner_email']."<br>";
                                                        echo "<span style='color:green'>Reserve Met</span>";
                                                    }
                                                else
                                                    {
                                                        echo "<span style='color:red'>Reserve Not Met</span><br>";
                                                        echo "Highest: $".number_format($row['current_bid'],2);
                                                    }
                                            }
                                        else
                                            {
                                                echo "No Bids";
                                            }
                                    }
                                else
                                    {
                                        echo "---";
                                    }
                                echo "</td>";
                                echo "<td>";
                                if($row['status']=='active' && $isActive)
                                    {
                                        echo "<a href='EditListing.php?id=".$row['id']."' id='edit_btn".$rowNum."'><input type='button' value='".($row['bid_count']==0 ? "Edit" : "View")."'></a> ";
                                        if($row['bid_count']==0)
                                            {
                                                echo "<input type='button' id='cancel_btn".$rowNum."' value='Cancel' onclick='CancelListing(".$row['id'].", ".$rowNum.")' style='background:red;color:white;'>";
                                            }
                                    }
                                else
                                    {
                                        echo "<a href='EditListing.php?id=".$row['id']."'><input type='button' value='View'></a>";
                                    }
                                echo "</td>";
                                echo "</tr>";
                                $rowNum++;
                            }
                    }
                else
                    {
                        echo "<tr><td colspan='10'>No listings yet. <a href='CreateListing.php'>Create your first listing</a></td></tr>";
                    }
                ?>
            </table>
        </div>
    </body>
</html>
