<?php
include "../Controller/CreateListingController.php";
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
            <h1>Create New Listing</h1>
            <?php if($message!=""){ echo "<span class='error'>".$message."</span><br><br>"; } ?>

            <form method="post" action="CreateListing.php" enctype="multipart/form-data">
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
                        <td>Category: <span class="required">*</span></td>
                        <td>
                            <select name="category_id">
                                <option value="">-- Select Category --</option>
                                <?php
                                if($categories && $categories->num_rows>0)
                                    {
                                        $categories->data_seek(0);
                                        while($cat = $categories->fetch_assoc())
                                            {
                                                $sel = ($category_id==$cat['id']) ? "selected" : "";
                                                echo "<option value='".$cat['id']."' ".$sel.">".$cat['name']."</option>";
                                            }
                                    }
                                ?>
                            </select>
                            <span class="error"><?php echo $catErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Starting Price ($): <span class="required">*</span></td>
                        <td><input type="number" name="starting_price" step="0.01" min="0.01" value="<?php echo $starting_price; ?>"> <span class="error"><?php echo $priceErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Reserve Price ($): <small>(optional)</small></td>
                        <td><input type="number" name="reserve_price" step="0.01" min="0" value="<?php echo $reserve_price; ?>"> <span class="error"><?php echo $reserveErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>Image (JPEG/PNG max 3MB):</td>
                        <td><input type="file" name="image" accept=".jpg,.jpeg,.png"> <span class="error"><?php echo $imageErr; ?></span></td>
                    </tr>
                    <tr>
                        <td>End Date & Time: <span class="required">*</span></td>
                        <td><input type="datetime-local" name="end_datetime" value="<?php echo $end_datetime; ?>"> <span class="error"><?php echo $endErr; ?></span><br><small>Must be at least 1 hour from now</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Create Listing"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
