<?php

include "../Model/db.php";

$email=$_POST["email"]??"";
if(!$email)
    {
        echo "Email Required";
    }
    else{
        $database = new db();
        $connection = $database->connection();
        $result= $database->CheckEmail($connection, "users", $email);
        if($result->num_rows>0)
            {
                echo "Email Already Taken";
            }
            else{
                echo "Email Available";
            }

    }
?>
