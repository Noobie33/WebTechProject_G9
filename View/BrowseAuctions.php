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
            echo "<h1>Browse Auctions Page</h1>";
            echo "This page will be completed in another task.";
        ?>
        <br><br>
        <a href="Dashboard.php">Back To Dashboard</a>
    </body>
</html>
