<?php
include "../Controller/AdminSellerRequestController.php";
echo "<h1>Admin Seller Request Page </h1> <br>";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Design/Style.css">
        <Script src ="../Controller/JS/SellerApproval.js"> </Script>
    </head>
    <body>
        <div class="nav">
            <a href="Dashboard.php">Dashboard</a>
            <a href="AdminDashboard.php">Admin Dashboard</a>
            <a href="CategoryManage.php">Category Manage</a>
            <a href="../Controller/Logout.php">Logout</a>
        </div>

        <table border="1">
            <tr>
                <td>User ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Bio</td>
                <td>Motivation</td>
                <td>Status</td>
                <td>Action</td>
            </tr>
            <?php
            if($result->num_rows>0)
                {
                    $count=1;
                    while($row=$result->fetch_assoc())
                        {
                            echo "<tr id='row".$count."'>";
                            echo "<td>".$row["user_id"]."</td>";
                            echo "<td>".$row["name"]."</td>";
                            echo "<td>".$row["email"]."</td>";
                            echo "<td>".$row["phone"]."</td>";
                            echo "<td>".$row["bio"]."</td>";
                            echo "<td>".$row["motivation"]."</td>";
                            echo "<td id='status".$count."'>".$row["status"]."</td>";
                            echo "<td id='action".$count."'>";
                            echo "<button onclick='ApproveSeller(".$row["user_id"].",".$count.")'>Approve</button> ";
                            echo "<button onclick='RejectSeller(".$row["user_id"].",".$count.")'>Reject</button>";
                            echo "</td>";
                            echo "</tr>";
                            $count++;
                        }
                }
                else{
                    echo "<tr><td colspan='8'>No Pending Seller Request</td></tr>";
                }
            ?>
        </table>
    </body>
</html>
