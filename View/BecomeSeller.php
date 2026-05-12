<?php
include "../Controller/SellerRequestController.php";
echo "<h1>Become Seller Page </h1> <br>";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css">
    </head>
    <body>
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
        <form method = "post" action="BecomeSeller.php">
            <table>
                <tr>
                    <td>Motivation: </td>
                    <td><textarea name="motivation"><?php echo $motivation ?></textarea> <span class="error"><?php echo $motivationErr ?></span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Submit Request"></td>
                </tr>
            </table>
        </form>
        <?php
        }
        ?>
        <br>
        <a href="Dashboard.php">Back To Dashboard</a>
    </body>
</html>
