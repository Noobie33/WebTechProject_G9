<?php
include "../Model/db.php";
session_start();

header("Content-Type: application/json");

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true || $_SESSION["role"]!="admin")
    {
        echo json_encode(array("ok"=>false,"message"=>"Unauthorized"));
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);

$stats = $database->GetAdminStats($connection);
$catResult = $database->GetTopCategories($connection);

$labels = array();
$data = array();
while($row = $catResult->fetch_assoc())
    {
        $labels[] = $row["name"];
        $data[] = intval($row["completed_count"]);
    }

echo json_encode(array(
    "ok"=>true,
    "stats"=>$stats,
    "labels"=>$labels,
    "data"=>$data
));
?>
