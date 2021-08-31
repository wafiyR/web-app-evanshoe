<?php
require_once "db/dbConfig.php";
// include "login.php";
// include "register.php";
session_start();

// display product details from db

$param_username = $_SESSION["username"];

$status_payment = "PAID";

$get_inventory = "SELECT id, image, brand, name, quantity, price FROM cart WHERE username = '$param_username' AND status_payment = '$status_payment' ";

$result = mysqli_query($conn, $get_inventory);
?>

<!DOCTYPE html>
<html>

    <head>

        <title>Home Page</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- for responsive page? -->

        <link rel="stylesheet" type="text/css" href="css/user_style.css"> 
        <!--<link rel="stylesheet" type="text/css" href="css/indexStyle.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="css/form_style.css"> -->

        <!--<style>
            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                max-width: 300px;
                margin: auto;
                text-align: center;
                font-family: arial;
                float: left;
                
            }

            .price {
                color: grey;
                font-size: 22px;
            }

            .card button {
                border: none;
                outline: 0;
                padding: 12px;
                color: white;
                background-color: #000;
                text-align: center;
                cursor: pointer;
                width: 100%;
                font-size: 18px;
            }

            .card button:hover {
                opacity: 0.7;
            }
        </style> -->
    </head>

    <body>

        <ul class="topnav">
            <li><a href="user_home.php">Home</a></li> <!-- display available shoes // purchase area (add to cart, quantity)-->
            <li><a class="active" href="user_history.php">Purchase History</a></li>
            <li><a href="user_cart.php">My Cart</a></li>
            <!-- <li><a onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;">Login</a></li>
            <li><a onclick="document.getElementById('id02').style.display = 'block'" style="width:auto;">Register</a></li> -->
            <li><a href="logout.php">Logout</a></li>
            <!-- <li class="right"><a href="#about">Logout</a></li> -->
        </ul>

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

        <h1 style="text-align: center;">Purchase History</h1>       

        <br>
        <br>
        <br>

        <form action="user_home.php" method="post" enctype="multipart/form-data"> <!-- enctype="image/jpg" -->

            <table class="card" align="center" border="1px solid white" style="width:1200px; line-height:40px; border-collapse: collapse;"> <!-- border-spacing: 0; border-collapse: separate; border-collapse: collapse; border-radius: 25px; -->
                <!-- style="border-collapse: collapse; border-radius: 30px; border-style: hidden; box-shadow: 0 0 0 1px #666;" -->
                <th>Id</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Name</th>                
                <th>Quantity</th>
                <th>Total Price(RM)</th>




<?php
//echo $curr_id;
//while($rows=mysqli_fetch_array($result))
while ($rows = mysqli_fetch_array($result)) {
    ?>
                    <tr>
                        <!--<td align="center"><img src = "<?php //echo $rows['image'];                  ?>" height="128" width="128" ></td> -->
                        <!-- <td align="center"> <?php //echo '<img src="'.$rows['image'].'" height="128" width="128" />';                 ?></td> -->
                        <!--<td align="center"><img img="/getImage.php?id=1"/></td> -->

                                                                                            <!--<td align="center"> <?php //echo "<img src = 'C:\wamp64\www\Ammar".$rows['img']."' >";                   ?></td>-->
                        <td align="center"><?php echo $rows['id']; ?></td>
                        <td align="center"><?php echo '<img src="data:image/jpg;base64,' . base64_encode($rows['image']) . '" height="150" width="150" />'; ?></td>
                        <td align="center"><?php echo $rows['brand']; ?></td>
                        <td align="center"><?php echo $rows['name']; ?></td>
                        <!--<td align="center"><?php //echo $rows['serial_no'];  ?></td>-->
                        <td align="center"><?php echo $rows['quantity']; ?></td>
                        <td align="center"><?php echo $rows['price']; ?></td>
                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px; background-color: red;" name="deleteItem" value="' . $rows['id'] . '">Delete</button> '  ?></td>-->
                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #2E2E2E; color: white;"  name="addToCart" value="' . $rows['id'] . '">Add to Cart</button> '  ?></td>-->
                    </tr>
    <?php
}
?>
            </table>     

        </form>

    </body>
</html>
