<?php
include "../Controller/AdminSellerRequestController.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src ="../Controller/JS/SellerApproval.js"> </Script>
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
            <h1>Seller Verification Requests</h1>
            <table border="1" class="data-table">
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
                                echo "<button class='approve-btn' onclick='ApproveSeller(".$row["user_id"].",".$count.")'>Approve</button>";
                                echo "<button class='reject-btn' onclick='RejectSeller(".$row["user_id"].",".$count.")'>Reject</button>";
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
        </div>
    </body>
</html>
