<?php
include "../Controller/loginvalidation.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Design/Style.css">
    </head>
    <body>
        <form method ='post' action ="Login.php">
            <?php
            echo "<h1 style='color: red'>LogIn Page</h1>";
            if(isset($_SESSION["success"]))
                {
                    echo "<span class='message'>".$_SESSION["success"]."</span><br><br>";
                    unset($_SESSION["success"]);
                }
            ?>
            <table>
                <tr>
                    <td> Email: </td>
                    <td> <input type="text" name = "email" value="<?php echo $email ?>"/> <span class="error"><?php echo $emailErr ?></span> </td>
                </tr>
                <tr>
                    <td> Password: </td>
                    <td > <input type ="password" name ="password"> <span class="error"><?php echo $passwordErr ?></span> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td>
                        <input type ="submit"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> <span class="error"><?php echo $message; ?></span> </td>
                </tr>
            </table>
        </form>
        <br>
        New User? <a href="Registration.php">Registration</a>
        <br><br>
        Admin Login: admin@gmail.com / admin123
    </body>
</html>
