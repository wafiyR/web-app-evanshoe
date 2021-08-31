<?php
// require_once "db/dbConfig.php";
// include "login.php";
// include "register.php";

require_once "db/dbConfig.php";

session_start();

$param_username = $_SESSION["username"];

$param_user_type = "admin";

$display_profile = "SELECT id, email, name FROM user_info WHERE user_type = '$param_user_type' ";

$result = mysqli_query($conn, $display_profile);

if (isset($_POST['update_admin'])) {

    $admin_id = $_POST['update_admin'];

    if (!empty($_POST['new_username'])) {

        $new_username = $_POST['new_username'];

        $sql = "UPDATE user_info SET name = ? WHERE id = '$admin_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "s", $param_update_username);

            $param_update_username = $new_username;

            mysqli_stmt_execute($query_stmt);

            header("location: admin_home.php");
        }
    } else if (!empty($_POST['new_email'])) {

        $new_email = $_POST['new_email'];

        $sql = "UPDATE user_info SET email = ? WHERE id = '$admin_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "s", $param_update_email);

            $param_update_email = $new_email;

            mysqli_stmt_execute($query_stmt);

            header("location: admin_home.php");
        }
    }
}
?>

<!DOCTYPE html>
<html>

    <head>

        <title>Admin - Main Page</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- for responsive page? -->

        <link rel="stylesheet" type="text/css" href="css/style_admin.css"> 
        <!-- <link rel="stylesheet" type="text/css" href="css/form_style.css"> -->

    </head>

    <body>

        <ul class="topnav">
            <li><a class="active" href="admin_home.php">Home</a></li> 
            <!--<li><a href="admin_profile.php">Admin Profile</a></li>-->
            <li><a href="inventory.php">Inventory</a></li> <!-- Add Menu, Update/Delete Menu-->
            <li><a href="user_order.php">Orders</a></li>
            <li><a href="sales_report.php">Sales Report</a></li>
            <!-- <li><a onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;">Login</a></li>
            <li><a onclick="document.getElementById('id02').style.display = 'block'" style="width:auto;">Register</a></li> -->
            <li><a href="logout.php">Logout</a></li>
            <!-- <li class="right"><a href="#about">Logout</a></li> -->
        </ul>

        <!--<header class="bgimg" style="position: relative;"></header>-->

        <div class="header">
            <h2>Admin Profile</h2>
        </div>
        
        <br><br><br><br><br>

        <form method="post" action="admin_home.php">

            <!--<h2 style="position:absolute; top:25%; left:50%; float:left;">Admin Profile</h2>-->
            
            <table class="admin_profile" align="center" border="1px solid white" style="width:800px; line-height:40px; border-collapse: collapse;"> <!-- align = "center" -->
                <th>Admin ID</th>
                <th>Username</th>
                <th>Email</th>                    
                <!--<th>Delete</th>-->
                <th>Update</th>
                <?php
                while ($rows = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <!-- <td align="center"><?php echo '<input type="radio" style="inline" name="selectupdate" value="' . $rows['orders'] . '"> ' ?></td> -->
                        <td align="center"><?php echo $rows['id']; ?></td>
                        <!-- <td align="center"><img src = " <?php echo $rows['Images']; ?>" height="128" width="128" ></td> -->
                        <td align="center"><?php echo $rows['name']; ?></td>
                        <td align="center"><?php echo $rows['email']; ?></td>      
                        <!-- <td align="center" ><?php echo "<img src='Images/" . $rows['Images'] . "'>" ?></td> --> 

                                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px;" name="deleteAdmin" value="' . $rows['Admin_id'] . '">Delete</button> '    ?></td>-->	
                                        <!--<td align="center"><?php echo '<button type="submit" style="inline" name="updamtorder" value="' . $rows['id'] . '">Update</button> ' ?></td> -->
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #006200; color: white;" name="update_admin" value="' . $rows['id'] . '">Update</button> ' ?></td>
                    </tr>
                <?php }
                ?>
            </table>

            <div class="update-form">

                <h4 style="text-align: center; color:white;">Update Profile</h4>

                <input type="text" name="new_username" placeholder="Update Username" >

                <input type="text" name="new_email" placeholder="Update Email" >

            </div>          

        </form>

    </body>
</html>
