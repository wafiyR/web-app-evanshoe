<?php
require_once "db/dbConfig.php";
// include "login.php";
// include "register.php";
//session_start();
// display product details from db
//$param_username = $_SESSION["username"];

$status_payment = "PAID";

$sum = "SELECT SUM(price) FROM cart WHERE status_payment = '$status_payment'";

$total_sum = mysqli_query($conn, $sum);





$display_report = "SELECT id, image, brand, name, COUNT(quantity) FROM cart WHERE status_payment = '$status_payment' GROUP BY item_id ";

$result = mysqli_query($conn, $display_report);
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
            <li><a href="admin_home.php">Home</a></li> 
            <!--<li><a href="admin_profile.php">Admin Profile</a></li>-->
            <li><a href="inventory.php">Inventory</a></li> <!-- Add Menu, Update/Delete Menu-->
            <li><a href="user_order.php">Orders</a></li>
            <li><a class="active" href="sales_report.php">Sales Report</a></li>
            <!-- <li><a onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;">Login</a></li>
            <li><a onclick="document.getElementById('id02').style.display = 'block'" style="width:auto;">Register</a></li> -->
            <li><a href="logout.php">Logout</a></li>
            <!-- <li class="right"><a href="#about">Logout</a></li> -->
        </ul>

        <!--<header class="bgimg" style="position: relative;"></header>-->

        <br>
        <br>
        <br>
        <!--<header class="bgimg" style="position: relative;"></header> -->

        <!-- <div class="card">
             <img src="img/nike_adapt_bb.jpg" alt="Denim Jeans" style="width:100%">
             <h1>Tailored Jeans</h1>
             <p class="price">$19.99</p>
             <p>Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem jeamsun denim lorem jeansum.</p>
             <p><button>Add to Cart</button></p>
         </div> -->

        <form action="user_home.php" method="post" enctype="multipart/form-data"> <!-- enctype="image/jpg" -->

            <table class="card" align="center" border="1px solid white" style="width:1200px; line-height:40px; border-collapse: collapse;"> <!-- border-spacing: 0; border-collapse: separate; border-collapse: collapse; border-radius: 25px; -->
                <!-- style="border-collapse: collapse; border-radius: 30px; border-style: hidden; box-shadow: 0 0 0 1px #666;" -->
                <th>Id</th>               
                <th>Image</th>
                <th>Brand</th>
                <th>Name</th>                
                <!--<th>Quantity</th>-->
                <th>Total of Orders</th>




                <?php
//echo $curr_id;
//while($rows=mysqli_fetch_array($result))
                while ($rows = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <!--<td align="center"><img src = "<?php //echo $rows['image'];                   ?>" height="128" width="128" ></td> -->
                        <!-- <td align="center"> <?php //echo '<img src="'.$rows['image'].'" height="128" width="128" />';                  ?></td> -->
                        <!--<td align="center"><img img="/getImage.php?id=1"/></td> -->

                                                                                                <!--<td align="center"> <?php //echo "<img src = 'C:\wamp64\www\Ammar".$rows['img']."' >";                    ?></td>-->
                        <td align="center"><?php echo $rows['id']; ?></td>                        
                        <td align="center"><?php echo '<img src="data:image/jpg;base64,' . base64_encode($rows['image']) . '" height="150" width="150" />'; ?></td>
                        <td align="center"><?php echo $rows['brand']; ?></td>
                        <td align="center"><?php echo $rows['name']; ?></td>
                        <!--<td align="center"><?php //echo $rows['serial_no'];   ?></td>-->
                       <!-- <td align="center"><?php //echo $rows['quantity'];  ?></td> -->
                        <td align="center"><?php echo $rows['COUNT(quantity)']; ?></td>
                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px; background-color: red;" name="deleteItem" value="' . $rows['id'] . '">Delete</button> '   ?></td>-->
                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #2E2E2E; color: white;"  name="addToCart" value="' . $rows['id'] . '">Add to Cart</button> '   ?></td>-->
                    </tr>
                    <?php
                }
                ?>

                <table class="total" align="" border="1px solid white" style="position:absolute; top:85%; left:38%; float:left;width:600px; line-height:40px;" >
                    <?php
                    while ($rows = mysqli_fetch_assoc($total_sum)) {
                        ?>

                        <th>Total of Profits(RM)</th>

                        <td><?php echo $rows['SUM(price)']; ?></td>	

                        <?php
                    }
                    ?>
                </table>
            </table>     

        </form>


    </body>
</html>
