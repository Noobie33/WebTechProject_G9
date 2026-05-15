<?php
include "../Model/db.php";
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true || $_SESSION["role"]!="admin")
    {
        Header("Location:../View/Login.php");
        exit;
    }

$database = new db();
$connection = $database->connection();

$message = "";
$categoryName = "";
$categoryNameErr = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if($_POST["action"]=="add")
            {
                $categoryName = trim($_POST["category_name"]);
                if(empty($categoryName))
                    {
                        $categoryNameErr = "Category name required";
                    }
                else
                    {
                        $result = $database->AddCategory($connection, $categoryName);
                        if($result)
                            {
                                $message = "Category added successfully";
                                $categoryName = "";
                            }
                        else
                            {
                                $categoryNameErr = "Category already exists";
                            }
                    }
            }

        if($_POST["action"]=="edit")
            {
                $edit_id = $_POST["category_id"];
                $edit_name = trim($_POST["category_name"]);
                if(empty($edit_name))
                    {
                        $message = "Category name required";
                    }
                else
                    {
                        $result = $database->UpdateCategory($connection, $edit_id, $edit_name);
                        if($result){ $message = "Category updated"; }
                        else{ $message = "Update failed"; }
                    }
            }

        if($_POST["action"]=="delete")
            {
                header("Content-Type: application/json");
                $cat_id = $_POST["category_id"];
                $used = $database->CheckCategoryUsed($connection, $cat_id);
                if($used > 0)
                    {
                        echo json_encode(array("ok"=>false,"message"=>"Cannot delete: category used by ".$used." listing(s)"));
                    }
                else
                    {
                        $result = $database->DeleteCategory($connection, $cat_id);
                        if($result){ echo json_encode(array("ok"=>true,"message"=>"Category deleted")); }
                        else{ echo json_encode(array("ok"=>false,"message"=>"Delete failed")); }
                    }
                exit;
            }
    }

$categories = $database->ShowCategory($connection);
?>
