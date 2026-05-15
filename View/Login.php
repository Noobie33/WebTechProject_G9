<?php
include "../Controller/loginvalidation.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
    </head>
    <body>
        <form method ='post' action ="Login.php">
            <?php
            echo "<h1>Login</h1>";
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
                        <input type ="submit" value="Login"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> <span class="error"><?php echo $message; ?></span> </td>
                </tr>
            </table>
            <div class="auth-note">
                New User? <a href="Registration.php">Create Account</a>
                <br><br>
                <b>Admin Login</b><br>
                Email: admin@gmail.com<br>
                Password: admin123
            </div>
        </form>

    </body>
</html>
