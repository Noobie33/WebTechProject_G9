<?php
include "../Controller/BrowseAuctionController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src="../Controller/JS/ListingCountdown.js"></Script>
        <Script src="../Controller/JS/AuctionBrowse.js"></Script>
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
            <h1>Browse Auctions</h1>

            <table>
                <tr>
                    <td>Search: <input type="text" id="search_input" onkeyup="OnSearchInput(this.value)" placeholder="Search by title..."></td>
                    <td>
                        &nbsp;&nbsp; Filter by Category:
                        <select onchange="FilterByCategory(this.value)">
                            <option value="0">All Categories</option>
                            <?php
                            if($categories && $categories->num_rows>0)
                                {
                                    while($cat = $categories->fetch_assoc())
                                        {
                                            echo "<option value='".$cat['id']."'>".$cat['name']."</option>";
                                        }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <br>

            <table border="1" class="data-table">
                <tr>
                    <td>Image</td>
                    <td>Title</td>
                    <td>Category</td>
                    <td>Current Bid</td>
                    <td>Bids</td>
                    <td>Ends In</td>
                    <td>Action</td>
                </tr>
                <tbody id="listings_container">
                <?php
                if($listings && $listings->num_rows>0)
                    {
                        while($row = $listings->fetch_assoc())
                            {
                                echo "<tr>";
                                echo "<td>";
                                if($row['image_path']){ echo "<img src='../".$row['image_path']."' width='60' height='50'>"; }
                                else{ echo "No Image"; }
                                echo "</td>";
                                echo "<td>".htmlspecialchars($row['title'])."</td>";
                                echo "<td>".$row['category_name']."</td>";
                                echo "<td>$".number_format($row['current_bid'],2)."</td>";
                                echo "<td>".$row['bid_count']."</td>";
                                echo "<td><span data-end='".$row['end_datetime']."'></span></td>";
                                echo "<td><a href='AuctionDetails.php?id=".$row['id']."'><input type='button' value='View & Bid'></a></td>";
                                echo "</tr>";
                            }
                    }
                else
                    {
                        echo "<tr><td colspan='7'>No active auctions at the moment.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
