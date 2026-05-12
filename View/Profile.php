<?php
include "../Controller/ProfileController.php";
echo "<h1>Profile Page </h1> <br>";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Design/Style.css">
    </head>
    <body>
        <form method = "post" action="Profile.php">
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
                    <td><textarea name="bio"><?php echo $bio ?></textarea></td>
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
        <br>
        <a href="Dashboard.php">Back To Dashboard</a>
    </body>
</html>
