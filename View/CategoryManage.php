<?php
include "../Controller/CategoryController.php";
session_start();
$isloggedIn=$_SESSION["loggedIn"] ?? false;
if(!$isloggedIn)
    {
        Header("Location:Login.php"); 
    }
if($_SESSION["role"]!="admin")
    {
        Header("Location:Dashboard.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/WebTechProject_G9/View/Design/Style.css">
        <Script src="../Controller/JS/CategoryDelete.js"></Script>

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
           <h1>Category Management</h1>
           <?php
                if($message!="")
                    { 
                        echo "<span class='message'>".$message."</span><br><br>"; 
                    } 
            ?>

            <h3>Add New Category</h3>
            <form method="post" action="CategoryManage.php">
                <input type="hidden" name="action" value="add">
                <table>
                    <tr>
                        <td>Category Name:</td>
                        <td><input type="text" name="category_name" value="<?php echo $categoryName; ?>"> <span class="error"><?php echo $categoryNameErr; ?></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Add Category"></td>
                    </tr>
                </table>
            </form>

            <br>
            <h3>Existing Categories</h3>
            <table border="1" class="data-table">
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Actions</td>
                </tr>
                <?php
                if($categories && $categories->num_rows>0)
                    {
                        while($cat = $categories->fetch_assoc())
                            {
                                echo "<tr id='cat_row_".$cat['id']."'>";
                                echo "<td>".$cat['id']."</td>";
                                echo "<td>";
                                echo "<span id='cat_name_".$cat['id']."'>".$cat['name']."</span>";
                                echo "<form method='post' action='CategoryManage.php' id='edit_form_".$cat['id']."' style='display:none;margin-top:5px;'>";
                                echo "<input type='hidden' name='action' value='edit'>";
                                echo "<input type='hidden' name='category_id' value='".$cat['id']."'>";
                                echo "<input type='text' name='category_name' value='".$cat['name']."'>";
                                echo "<input type='submit' value='Save'>";
                                echo "<input type='button' value='Cancel' onclick=\"document.getElementById('edit_form_".$cat['id']."').style.display='none'; document.getElementById('edit_btn_".$cat['id']."').style.display='inline';\">";
                                echo "</form>";
                                echo "</td>";
                                echo "<td>";
                                echo "<input type='button' id='edit_btn_".$cat['id']."' value='Edit' onclick=\"document.getElementById('edit_form_".$cat['id']."').style.display='block'; this.style.display='none';\">";
                                echo " <input type='button' value='Delete' onclick='DeleteCategory(".$cat['id'].")'>";
                                echo "</td>";
                                echo "</tr>";
                            }
                    }
                else
                    {
                        echo "<tr><td colspan='3'>No categories yet</td></tr>";
                    }
                ?>
            </table>
        </div>
    </body>
</html>
