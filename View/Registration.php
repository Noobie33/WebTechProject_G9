<?php
include "../Controller/RegistrationController.php";
echo "<h1>Registration Page </h1> <br>";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src ="../Controller/JS/CheckEmail.js"> </Script>
    </head>
    <body>
        <form method = "post" action="Registration.php">
            <table>
                <tr>
                    <td> <label for ="name">Name: </label></td>
                    <td> <input type ="text" id="name" name="name" value="<?php echo $name ?>"> <span class="error"><?php echo $nameErr ?></span> </td>
                </tr>
                <tr>
                    <td> <label for ="email">Email: </label></td>
                    <td> <input type ="text" id="email" name="email" onkeyup=CheckEmail() value="<?php echo $email ?>"> <span class="error"><?php echo $emailErr ?></span> </td>
                    <td> <p id="emailresponse"> </p></td>
                </tr>
                <tr>
                    <td> <label for ="phone">Phone: </label></td>
                    <td> <input type ="text" id="phone" name="phone" value="<?php echo $phone ?>"> <span class="error"><?php echo $phoneErr ?></span> </td>
                </tr>
                <tr>
                    <td> <label for ="bio">Bio: </label></td>
                    <td> <textarea name="bio"><?php echo $bio ?></textarea> </td>
                </tr>
                <tr>
                    <td> <label for ="password">Password:  </label></td>
                    <td> <input type ="password" id ="pass" name ="password"> <span class="error"><?php echo $passwordErr ?></span></td>
                </tr>
                <tr>
                    <td> <label for ="confirm_password">Confirm Password:  </label></td>
                    <td> <input type ="password" id ="confirm_password" name ="confirm_password"> <span class="error"><?php echo $confirmPasswordErr ?></span></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> <input type ="submit" id="submitbutton" name = "submit"> </td>
                </tr>
                <tr>
                    <td colspan="2"> <span class="message"><?php echo $message; ?></span> </td>
                </tr>
            </table>
        </form>
        <br>
        Already Registered? <a href="Login.php">Login</a>
    </body>
</html>
