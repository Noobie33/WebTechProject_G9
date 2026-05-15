<?php
include "../Controller/RegistrationController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src ="../Controller/JS/CheckEmail.js"> </Script>
    </head>
    <body>
        <form method = "post" action="Registration.php">
            <h1>Registration</h1>
            <table>
                <tr>
                    <td> <label for ="name">Name <span class="required">*</span></label></td>
                    <td> <input type ="text" id="name" name="name" value="<?php echo $name ?>"> <span class="error"><?php echo $nameErr ?></span> </td>
                </tr>
                <tr>
                    <td> <label for ="email">Email <span class="required">*</span></label></td>
                    <td> 
                        <input type ="text" id="email" name="email" onkeyup=CheckEmail() value="<?php echo $email ?>"> 
                        <span class="error"><?php echo $emailErr ?></span>
                        <p id="emailresponse"> </p>
                    </td>
                </tr>
                <tr>
                    <td> <label for ="phone">Phone <span class="required">*</span></label></td>
                    <td> <input type ="text" id="phone" name="phone" value="<?php echo $phone ?>"> <span class="error"><?php echo $phoneErr ?></span> </td>
                </tr>
                <tr>
                    <td> <label for ="bio">Bio </label></td>
                    <td> <textarea name="bio" placeholder="Write a short bio"><?php echo $bio ?></textarea> </td>
                </tr>
                <tr>
                    <td> <label for ="password">Password <span class="required">*</span></label></td>
                    <td> <input type ="password" id ="pass" name ="password"> <span class="error"><?php echo $passwordErr ?></span></td>
                </tr>
                <tr>
                    <td> <label for ="confirm_password">Confirm Password <span class="required">*</span></label></td>
                    <td> <input type ="password" id ="confirm_password" name ="confirm_password"> <span class="error"><?php echo $confirmPasswordErr ?></span></td>
                </tr>
                <tr>
                    <td> </td>
                    <td> <input type ="submit" id="submitbutton" name = "submit" value="Register"> </td>
                </tr>
                <tr>
                    <td colspan="2"> <span class="message"><?php echo $message; ?></span> </td>
                </tr>
            </table>
            <div class="auth-note">
                Already Have an Account? <a href="Login.php">Login</a>
            </div>
        </form>
    </body>
</html>
