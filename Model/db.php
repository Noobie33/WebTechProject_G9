<?php
class db{
function connection()
{
$db_host = "localhost";
$db_user= "root";
$db_password="";
$db_name="auction_system_g9";

$connection=  new mysqli($db_host, $db_user,$db_password,$db_name);
if($connection->connect_error)
    {
        die ("Could not Connect Database".$connection->connect_error);
    }
return $connection;
}

function CheckEmail($connection, $tablename, $email)
{
    $sql = "SELECT * FROM ".$tablename." WHERE email=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("s",$email);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function signup($connection, $tablename, $name, $email, $phone, $bio, $password_hash)
{
    $role="buyer";
    $seller_verified=0;
    $sql= "INSERT INTO " .$tablename. "(name, email, phone, bio, password_hash, role, seller_verified) VALUES (?,?,?,?,?,?,?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("ssssssi",$name, $email, $phone, $bio, $password_hash, $role, $seller_verified);
    $result = $statement->execute();
    return $result;
}

function signin($connection, $tablename, $email)
{
    $sql = "SELECT * FROM ".$tablename." WHERE email=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("s",$email);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function UserInfo($connection, $tablename, $id)
{
    $sql = "SELECT * FROM ".$tablename." WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function UpdateProfile($connection, $tablename, $id, $name, $phone, $bio)
{
    $sql= "UPDATE ".$tablename." SET name=?, phone=?, bio=? WHERE id=?";
    $statement=$connection->prepare($sql);
    $statement->bind_param("sssi",$name, $phone, $bio, $id);
    $result = $statement->execute();
    return $result;
}

function CheckSellerRequest($connection, $tablename, $user_id)
{
    $sql = "SELECT * FROM ".$tablename." WHERE user_id=? ORDER BY id DESC LIMIT 1";
    $statement=$connection->prepare($sql);
    $statement->bind_param("i",$user_id);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function SellerRequest($connection, $tablename, $user_id, $motivation)
{
    $status="pending";
    $sql= "INSERT INTO ".$tablename."(user_id, motivation, status) VALUES (?,?,?)";
    $statement=$connection->prepare($sql);
    $statement->bind_param("iss",$user_id, $motivation, $status);
    $result = $statement->execute();
    return $result;
}


}
?>
