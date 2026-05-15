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

function PendingSellerRequest($connection)
{
    $sql = "SELECT seller_requests.id AS request_id, seller_requests.user_id, seller_requests.motivation, seller_requests.status, seller_requests.created_at,
            users.name, users.email, users.phone, users.bio, users.seller_verified
            FROM seller_requests
            INNER JOIN users ON seller_requests.user_id=users.id
            WHERE seller_requests.status='pending' AND users.seller_verified=0
            ORDER BY seller_requests.created_at ASC";

    $statement=$connection->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
}

function ApproveSeller($connection, $user_id)
{
    $verified=1;
    $approved="approved";

    $sql1= "UPDATE users SET seller_verified=? WHERE id=?";
    $statement1=$connection->prepare($sql1);
    $statement1->bind_param("ii",$verified, $user_id);
    $result1 = $statement1->execute();

    $sql2= "UPDATE seller_requests SET status=? WHERE user_id=? AND status='pending'";
    $statement2=$connection->prepare($sql2);
    $statement2->bind_param("si",$approved, $user_id);
    $result2 = $statement2->execute();

    if($result1 && $result2)
        {
            return true;
        }
        else{
            return false;
        }
}

function RejectSeller($connection, $user_id)
{
    $rejected="rejected";
    $sql= "UPDATE seller_requests SET status=? WHERE user_id=? AND status='pending'";
    $statement=$connection->prepare($sql);
    $statement->bind_param("si",$rejected, $user_id);
    $result = $statement->execute();
    return $result;
}


// Task 2 functions will be added here later.
// Task 3 functions will be added here later.
// Task 4 functions will be added here later.

}
?>
