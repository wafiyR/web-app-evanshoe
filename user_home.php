<?php
require_once "db/dbConfig.php";
// include "login.php";
// include "register.php";
session_start();
// display product details from db
$get_inventory = "SELECT id, image, brand, name, quantity, price FROM inventory";
$result = mysqli_query($conn, $get_inventory);


if (isset($_POST['addToCart'])) {

    $item_id = $_POST['addToCart'];

    //$quantity = $_POST['quantity'];

    $query = "SELECT id, image, brand, name, price FROM inventory WHERE id = ?";

    if ($query_stmt = mysqli_prepare($conn, $query)) {

        mysqli_stmt_bind_param($query_stmt, "i", $param_item_id);

        $param_item_id = $item_id;

        mysqli_stmt_execute($query_stmt);

        mysqli_stmt_store_result($query_stmt);

        $query_stmt->bind_result($item_id, $item_image, $item_brand, $item_name, $item_price);

        if (mysqli_stmt_fetch($query_stmt)) {

            // need to check if the same item had already added in the cart?

            $sql = "INSERT INTO cart (username, item_id, image, brand, name, quantity, price, remainder_pay, status_payment, status_delivery) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {

                mysqli_stmt_bind_param($stmt, "ssssssssss", $param_username, $param_item_id, $param_item_image, $param_item_brand, $param_item_name, $param_quantity, $param_price, $param_remainder_pay, $param_status_payment, $param_status_delivery);

                $param_username = $_SESSION["username"];

                $param_item_id = $item_id;

                $param_item_image = $item_image;

                $param_item_brand = $item_brand;

                $param_item_name = $item_name;

                $param_quantity = 1;

                $param_price = $item_price;

                //$param_totalPrice = $price * $quantity;

                $param_remainder_pay = $item_price;

                $param_status_payment = "UNPAID";

                $param_status_delivery = "NOT DELIVERED";

                //$param_image = $image;

                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                    // header("location: UserLogin.php");           
                    echo "Order successfully added to Cart!";
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                    // echo $param_username;
                    // echo $param_menuID;
                    // echo $param_menuName;
                    // echo $param_menuPrice;
                    // echo $param_username;
                    // echo $Menu_id;
                    // echo $Menu_name;
                    // echo $price;
                }
            }
        }
    }



    // Close statement
    //mysqli_stmt_close($stmt);
}
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
            <li><a class="active" href="user_home.php">Home</a></li> <!-- display available shoes // purchase area (add to cart, quantity)-->
            <li><a href="user_history.php">Purchase History</a></li>
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

        <h1 style="text-align: center;">Available Shoes in Store</h1>       

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
                <th>In Stock</th>
                <th>Price(RM)</th>
                <th>Add to Cart</th>



                <?php
//echo $curr_id;
//while($rows=mysqli_fetch_array($result))
                while ($rows = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <!--<td align="center"><img src = "<?php //echo $rows['image'];                    ?>" height="128" width="128" ></td> -->
                        <!-- <td align="center"> <?php //echo '<img src="'.$rows['image'].'" height="128" width="128" />';                   ?></td> -->
                        <!--<td align="center"><img img="/getImage.php?id=1"/></td> -->

                                                                                                <!--<td align="center"> <?php //echo "<img src = 'C:\wamp64\www\Ammar".$rows['img']."' >";                    ?></td>-->
                        <td align="center"><?php echo $rows['id']; ?></td>
                        <td align="center"><?php echo '<img src="data:image/jpg;base64,' . base64_encode($rows['image']) . '" height="150" width="150" />'; ?></td>
                        <td align="center"><?php echo $rows['brand']; ?></td>
                        <td align="center"><?php echo $rows['name']; ?></td>
                        <!--<td align="center"><?php //echo $rows['serial_no'];   ?></td>-->
                        <td align="center"><?php echo $rows['quantity']; ?></td>
                        <td align="center"><?php echo $rows['price']; ?></td>
                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px; background-color: red;" name="deleteItem" value="' . $rows['id'] . '">Delete</button> '   ?></td>-->
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #2E2E2E; color: white;"  name="addToCart" value="' . $rows['id'] . '">Add to Cart</button> ' ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>     

        </form>

    </body>
</html>
