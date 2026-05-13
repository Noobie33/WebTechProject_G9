<?php
include "../Model/db.php";
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true || $_SESSION["role"]!="admin")
    {
        echo json_encode(array("ok"=>false,"message"=>"Unauthorized"));
    }
else{
        $user_id=$_POST["user_id"]??0;

        if($user_id<=0)
            {
                echo json_encode(array("ok"=>false,"message"=>"Invalid User"));
            }
            else{
                $database = new db();
                $connection = $database->connection();
                $result = $database->RejectSeller($connection,$user_id);

                if($result)
                    {
                        echo json_encode(array("ok"=>true,"message"=>"Seller Rejected"));
                    }
                    else{
                        echo json_encode(array("ok"=>false,"message"=>"Reject Failed"));
                    }
            }
    }
?>
