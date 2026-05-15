<?php
include "../Model/db.php";
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"]!=true)
    {
        Header("Location:Login.php");
        exit;
    }
if($_SESSION["role"]!="admin")
    {
        Header("Location:Dashboard.php");
        exit;
    }

$database = new db();
$connection = $database->connection();
$database->CloseExpiredAuctions($connection);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <Script src="../Controller/JS/AdminStats.js"></Script>
    </head>
    <body>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="AdminSellerRequests.php">Seller Requests</a>
            <a href="CategoryManage.php">Category Manage</a>
            <a href="AdminDashboard.php">Analytics</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>

        <div class="box">
            <h1>Admin Analytics Dashboard</h1>

            <table border="1" class="data-table">
                <tr>
                    <td style="padding:15px;text-align:center;">
                        <h3>Active Auctions</h3>
                        <p id="stat_active" style="font-size:2em;color:blue;">...</p>
                    </td>
                    <td style="padding:15px;text-align:center;">
                        <h3>Ended Auctions</h3>
                        <p id="stat_ended" style="font-size:2em;">...</p>
                    </td>
                    <td style="padding:15px;text-align:center;">
                        <h3>Total Bids</h3>
                        <p id="stat_bids" style="font-size:2em;color:blue;">...</p>
                    </td>
                    <td style="padding:15px;text-align:center;">
                        <h3>Highest Sale</h3>
                        <p id="stat_highest" style="font-size:2em;color:green;">...</p>
                    </td>
                </tr>
            </table>

            <br>
            <h3>Top 5 Categories by Completed Auctions</h3>
            <div style="max-width:600px;">
                <canvas id="topCategoriesChart" height="200"></canvas>
            </div>
        </div>
    </body>
</html>
