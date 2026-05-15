<?php
include "../Controller/AuctionDetailsController.php";

$isActive = ($auction['status']=='active' && strtotime($auction['end_datetime']) > time());
$isSeller = ($_SESSION["user_id"]==$auction['seller_id']);
$reserveMet = (!$auction['reserve_price'] || $auction['current_bid'] >= $auction['reserve_price']);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src="../Controller/JS/ListingCountdown.js"></Script>
        <Script src="../Controller/JS/Bidding.js"></Script>
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
            <h1><?php echo htmlspecialchars($auction['title']); ?></h1>

            <table>
                <tr>
                    <td>
                        <?php
                        if($auction['image_path'])
                            {
                                echo "<img src='../".$auction['image_path']."' width='300'>";
                            }
                        ?>
                    </td>
                    <td style="padding-left:20px;vertical-align:top;">
                        <?php
                        echo "<p><b>Category:</b> ".$auction['category_name']."</p>";
                        echo "<p><b>Seller:</b> ".$auction['seller_name']."</p>";
                        echo "<p><b>Description:</b><br>".nl2br(htmlspecialchars($auction['description']))."</p>";
                        echo "<p><b>Starting Price:</b> $".number_format($auction['starting_price'],2)."</p>";
                        echo "<p><b>Current Bid:</b> <span id='current_bid_display' style='font-size:1.2em;color:blue;'>$".number_format($auction['current_bid'],2)."</span></p>";
                        echo "<p><b>Total Bids:</b> <span id='bid_count_display'>".$bid_count."</span></p>";

                        echo "<p><b>Reserve:</b> ";
                        if($auction['reserve_price'])
                            {
                                if($reserveMet){ echo "<span style='color:green'>Reserve Met</span>"; }
                                else{ echo "<span style='color:red'>Reserve Not Met</span>"; }
                            }
                        else{ echo "No Reserve"; }
                        echo "</p>";

                        echo "<p><b>Status:</b> ";
                        if($isActive)
                            {
                                echo "<span style='color:green'>Active - Ends in: <span data-end='".$auction['end_datetime']."'></span></span>";
                            }
                        else if($auction['status']=='ended')
                            {
                                echo "<span style='color:#555'>Ended</span>";
                            }
                        else
                            {
                                echo "<span style='color:orange'>".ucfirst($auction['status'])."</span>";
                            }
                        echo "</p>";

                        if($auction['status']=='ended')
                            {
                                echo "<p><b>Auction Result:</b><br>";
                                if($winner_info && $reserveMet)
                                    {
                                        echo "Winner: ".$winner_info['winner_name']."<br>";
                                        echo "Winning Bid: $".number_format($winner_info['amount'],2);
                                    }
                                else if(!$reserveMet)
                                    {
                                        echo "<span style='color:red'>Reserve Not Met - No winner</span>";
                                    }
                                else
                                    {
                                        echo "No bids were placed";
                                    }
                                echo "</p>";
                            }

                        if($isActive && !$isSeller)
                            {
                                echo "<h3>Place a Bid</h3>";
                                echo "<input type='number' id='bid_amount' step='0.01' min='".($auction['current_bid']+0.01)."' placeholder='Enter amount > $".number_format($auction['current_bid'],2)."'>";
                                echo "<br><br>";
                                echo "<input type='button' value='Place Bid' onclick='PlaceBid(".$auction['id'].")'>";
                                echo "<p id='bid_message'></p>";
                            }
                        else if($isActive && $isSeller)
                            {
                                echo "<p class='error'>You cannot bid on your own listing.</p>";
                            }
                        ?>
                    </td>
                </tr>
            </table>

            <h3>Bid History (Last 10)</h3>
            <table border="1" class="data-table">
                <tr>
                    <td>Bidder</td>
                    <td>Amount</td>
                    <td>Time</td>
                </tr>
                <tbody id="bid_history_body">
                <?php
                if($bids && $bids->num_rows>0)
                    {
                        while($bid = $bids->fetch_assoc())
                            {
                                echo "<tr>";
                                echo "<td>".$bid['bidder_name']."</td>";
                                echo "<td>$".number_format($bid['amount'],2)."</td>";
                                echo "<td>".$bid['created_at']."</td>";
                                echo "</tr>";
                            }
                    }
                else
                    {
                        echo "<tr><td colspan='3'>No bids yet</td></tr>";
                    }
                ?>
                </tbody>
            </table>
            <br>
            <a href="BrowseAuctions.php">Back to Browse</a>
        </div>
    </body>
</html>