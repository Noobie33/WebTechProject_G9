<?php
include "../Controller/ProfileController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
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

        <form method = "post" action="Profile.php">
            <h1>My Profile</h1>
            <table>
                <tr>
                    <td>Name: </td>
                    <td><input type="text" name="name" value="<?php echo $name ?>"> <span class="error"><?php echo $nameErr ?></span></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><input type="text" value="<?php echo $email ?>" readonly></td>
                </tr>
                <tr>
                    <td>Phone: </td>
                    <td><input type="text" name="phone" value="<?php echo $phone ?>"> <span class="error"><?php echo $phoneErr ?></span></td>
                </tr>
                <tr>
                    <td>Bio: </td>
                    <td><textarea name="bio" placeholder="Write a short bio"><?php echo $bio ?></textarea></td>
                </tr>
                <tr>
                    <td>Role: </td>
                    <td><?php echo $role ?></td>
                </tr>
                <tr>
                    <td>Seller Status: </td>
                    <td>
                        <?php
                        if($seller_verified==1)
                            {
                                echo "Verified";
                            }
                            else{
                                echo "Not Verified";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Update Profile"></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="message"><?php echo $message ?></span></td>
                </tr>
            </table>
        </form>
    </body>
</html>
