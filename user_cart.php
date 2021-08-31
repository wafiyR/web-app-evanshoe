<?php
require_once "db/dbConfig.php";
// include "login.php";
// include "register.php";
session_start();

// display product details from db

$param_username = $_SESSION["username"];

$status_payment = "UNPAID";

$get_inventory = "SELECT id, image, brand, name, quantity, price, remainder_pay, status_payment FROM cart WHERE username = '$param_username' AND status_payment = '$status_payment' ";

$result = mysqli_query($conn, $get_inventory);


if (isset($_POST['pay_cart'])) {

    $cart_id = $_POST['pay_cart'];

    if (!empty($_POST['amount_pay'])) {

        $amount_pay = $_POST['amount_pay'];

        $sql = "UPDATE cart SET remainder_pay = ?, status_payment = ?  WHERE username = '$param_username' AND id  = '$cart_id'  ";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            $remainder_pay = "SELECT remainder_pay FROM cart WHERE id = '$cart_id'";
            $rem_pay = mysqli_query($conn, $remainder_pay);
            $rows = mysqli_fetch_assoc($rem_pay);

            mysqli_stmt_bind_param($query_stmt, "ss", $param_update_payment, $param_status_payment);

            $param_update_payment = $amount_pay - $rows['remainder_pay'];

            $param_status_payment = "PAID";

            // mysqli_stmt_execute($query_stmt);

            if (mysqli_stmt_execute($query_stmt)) {

                $get_quantity_cart = "SELECT quantity FROM cart WHERE id = '$cart_id'";
                $result_quantity_cart = mysqli_query($conn, $get_quantity_cart);
                $row_quantity_cart = mysqli_fetch_assoc($result_quantity_cart);

                $get_item_id = "SELECT item_id FROM cart WHERE id = '$cart_id' "; // get item_id from table cart with specific id (Cart ID) in cart
                $result_item_id = mysqli_query($conn, $get_item_id);
                $row_item_id = mysqli_fetch_assoc($result_item_id);

                $get_quantity_inventory = "SELECT quantity FROM inventory WHERE id = $row_item_id[item_id] "; // get item_id from table cart with specific id (Cart ID) in cart
                $result_quantity_inventory = mysqli_query($conn, $get_quantity_inventory);
                $row_quantity_inventory = mysqli_fetch_assoc($result_quantity_inventory);

                $update_inventory_quantity = $row_quantity_inventory['quantity'] - $row_quantity_cart['quantity'];

                $sql = "UPDATE inventory SET quantity = '$update_inventory_quantity'  WHERE id  = $row_item_id[item_id] ";

                mysqli_query($conn, $sql);
                //mysqli_stmt_execute($sql);

                header("location: user_cart.php");
            }
        }
    }
}

if (isset($_POST['update_cart'])) {

    $cart_id = $_POST['update_cart'];

    //echo "test";

    if (!empty($_POST['update_quantity'])) {

        //echo "test";

        $new_quantity = $_POST['update_quantity'];

        $get_item_id = "SELECT item_id FROM cart WHERE id = '$cart_id' "; // get item_id from table cart with specific id (Cart ID) in cart
        $result_item_id = mysqli_query($conn, $get_item_id);
        $row_item_id = mysqli_fetch_assoc($result_item_id);

        $new_total_price = "SELECT price FROM inventory WHERE id = $row_item_id[item_id] "; // get base/original price of item(shoes) from table inventory with specific item_id
        $result = mysqli_query($conn, $new_total_price);
        $row = mysqli_fetch_assoc($result);

        $total_price = $new_quantity * $row['price'];

        $sql = "UPDATE cart SET quantity = ?, price = ?, remainder_pay = ? WHERE id = '$cart_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "sss", $param_update_quantity, $param_update_total_price, $param_remainder_price);

            $param_update_quantity = $new_quantity;

            $param_update_total_price = $total_price;

            $param_remainder_price = $total_price;

            mysqli_stmt_execute($query_stmt);

            header("location: user_cart.php");
        }
    }
}


if (isset($_POST['delete_cart'])) {

    $cart_id = $_POST['delete_cart'];

    $query = "DELETE FROM cart WHERE id = ?"; // a better practice to not hard delete data, alternative is to update status of cart to "DELETED"

    if ($query_stmt = mysqli_prepare($conn, $query)) {

        mysqli_stmt_bind_param($query_stmt, "i", $param_item_id);

        $param_item_id = $cart_id;

        mysqli_stmt_execute($query_stmt);

        header("location: user_cart.php");
    }
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
            <li><a href="user_home.php">Home</a></li> <!-- display available shoes // purchase area (add to cart, quantity)-->
            <li><a href="user_history.php">Purchase History</a></li>
            <li><a class="active" href="user_cart.php">My Cart</a></li>
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

        <h1 style="text-align: center;">My Cart</h1>       

        <br>
        <br>
        <br>

        <form action="user_cart.php" method="post" enctype="multipart/form-data"> <!-- enctype="image/jpg" -->

            <table class="card" align="center" border="1px solid white" style="width:1350px; line-height:40px; border-collapse: collapse;"> <!-- border-spacing: 0; border-collapse: separate; border-collapse: collapse; border-radius: 25px; -->
                <!-- style="border-collapse: collapse; border-radius: 30px; border-style: hidden; box-shadow: 0 0 0 1px #666;" -->
                <th>Id</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Name</th>                
                <th>Quantity</th>
                <th>Total Price(RM)</th>
                <!--<th>Remainder Pay(RM)</th>-->
                <th>Status Payment</th>
                <th>Make Payment</th>
                <th>Update</th>
                <th>Delete</th>



                <?php
//echo $curr_id;
//while($rows=mysqli_fetch_array($result))
                while ($rows = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <!--<td align="center"><img src = "<?php //echo $rows['image'];                              ?>" height="128" width="128" ></td> -->
                        <!-- <td align="center"> <?php //echo '<img src="'.$rows['image'].'" height="128" width="128" />';                                ?></td> -->
                        <!--<td align="center"><img img="/getImage.php?id=1"/></td> -->

                                                                                                                                                    <!--<td align="center"> <?php //echo "<img src = 'C:\wamp64\www\Ammar".$rows['img']."' >";                                 ?></td>-->
                        <td align="center"><?php echo $rows['id']; ?></td>
                        <td align="center"><?php echo '<img src="data:image/jpg;base64,' . base64_encode($rows['image']) . '" height="150" width="150" />'; ?></td>
                        <td align="center"><?php echo $rows['brand']; ?></td>
                        <td align="center"><?php echo $rows['name']; ?></td>
                        <!--<td align="center"><?php //echo $rows['serial_no'];                ?></td>-->
                        <td align="center"><?php echo $rows['quantity']; ?></td>
                        <td align="center"><?php echo $rows['price']; ?></td>
                       <!-- <td align="center"><?php //echo $rows['remainder_pay'];              ?></td>-->
                        <td align="center"><?php echo $rows['status_payment']; ?></td>
                        <!--<td align="center"><?php //echo '<button type="submit" style="inline; height:50px; width:125px; background-color: red;" name="deleteItem" value="' . $rows['id'] . '">Delete</button> '                ?></td>-->
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #2E2E2E; color: white;"  name="pay_cart" value="' . $rows['id'] . '">Pay</button> ' ?></td>
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #006200; color: white;"  name="update_cart" value="' . $rows['id'] . '">Update</button> ' ?></td>
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #d80000; color: white;"  name="delete_cart" value="' . $rows['id'] . '">Delete</button> ' ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>     

            <div class="update-form">

                <h4 style="text-align: center; color:white;">Update Quantity</h4>

                <input type="text" name="update_quantity" placeholder="Update Quantity" >

            </div>

            <div class="payment-form">

                <h4 style="text-align: center; color:white;">Amount to Pay</h4>

                <input type="text" name="amount_pay" placeholder="RM0.00" >

            </div>

        </form>

    </body>
</html>
