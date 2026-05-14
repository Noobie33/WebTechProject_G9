<?php

include "../Model/db.php";

$email=trim($_POST["email"]??"");
if(!$email)
    {
        echo "Email Required";
    }
else if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$email))
    {
        echo "Invalid Email";
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