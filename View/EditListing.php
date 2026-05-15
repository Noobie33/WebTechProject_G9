<?php
include "../Controller/EditListingController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
    </head>
    <body>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="Profile.php">Profile</a>
            <a href="BrowseAuctions.php">Browse Auctions</a>
            <a href="CreateListing.php">Create Listing</a>
            <a href="SellerDashboard.php">Seller Dashboard</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>

        <div class="box">
            <h1>Edit Listing</h1>
            <?php if($message!=""){ echo "<span class='message'>".$message."</span><br><br>"; } ?>

            <?php
            if(!$can_edit)
                {
                    if($listing['status']!='active')
                        {
                            echo "<span class='error'>This listing is ".$listing['status']." and cannot be edited.</span><br><br>";
                        }
                    else
                        {
                            echo "<span class='error'>This listing has ".$bid_count." bid(s). Fields are read-only.</span><br><br>";
                        }
                    echo "<p><b>Title:</b> ".htmlspecialchars($listing['title'])."</p>";
                    echo "<p><b>Description:</b> ".nl2br(htmlspecialchars($listing['description']))."</p>";
                    if($listing['image_path'])
                        {
                            echo "<img src='../".$listing['image_path']."' width='200'><br>";
                        }
                }
            else
                {
            ?>
            <form method="post" action="EditListing.php?id=<?php echo $listing_id; ?>" enctype="multipart/form-data">
                <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
                <table>
                    <tr>
                        <td>Title: <span class="required">*</span></td>
                        <td><input type="text" name="title" value="<?php echo $title; ?>"> <span class="error"><?php echo $titleErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Description: <span class="required">*</span></td>
                        <td><textarea name="description"><?php echo $description; ?></textarea> <span class="error"><?php echo $descErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                            if($listing['image_path'])
                                {
                                    echo "<img src='../".$listing['image_path']."' width='100'><br>";
                                }
                            else
                                {
                                    echo "No image";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image (optional):</td>
                        <td><input type="file" name="image" accept=".jpg,.jpeg,.png"> <span class="error"><?php echo $imageErr; ?></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Save Changes"></td>
                    </tr>
                </table>
            </form>
            <?php } ?>
            <br><a href="SellerDashboard.php">Back to Seller Dashboard</a>
        </div>
    </body>
</html>
