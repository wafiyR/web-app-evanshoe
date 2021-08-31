<?php
require_once "db/dbConfig.php";
// include "login.php";
// include "register.php";

$brand = $name = $serial_no = $quantity = $price = "";

if (isset($_POST["btn_upload"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));

        $brand = $_POST["brand"];
        $name = $_POST["name"];
        $serial_no = $_POST["serial_no"];
        $quantity = $_POST["quantity"];
        $price = $_POST["price"];

        /*
         * Insert image data into database
         */

        //DB details
        //$dbHost = 'localhost';
        //$dbUsername = 'root';
        //$dbPassword = '*****';
        //$dbName = 'codexworld';
        //Create connection and select DB
        //$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        //$dataTime = date("Y-m-d H:i:s");
        //Insert image content into database
        //$insert = $db->query("INSERT into images (image, created) VALUES ('$imgContent', '$dataTime')");

        $insert = $conn->query("INSERT into inventory (image, brand, name, serial_no, quantity, price) VALUES ('$imgContent', '$brand', '$name', '$serial_no', '$quantity', '$price')");
        if ($insert) {
            // echo "File uploaded successfully.";
        } else {
            // echo "File upload failed, please try again.";
        }
    } else {
        echo "Please select an image file to upload.";
    }
}

if (isset($_POST['deleteItem'])) {

    $item_id = $_POST['deleteItem'];

    $query = "DELETE FROM inventory WHERE id = ?"; // a better practice to not hard delete data, alternative is to update status of cart to "DELETED"

    if ($query_stmt = mysqli_prepare($conn, $query)) {

        mysqli_stmt_bind_param($query_stmt, "i", $param_item_id);

        $param_item_id = $item_id;

        mysqli_stmt_execute($query_stmt);

        header("location: inventory.php");
    }
}

if (isset($_POST['updateItem'])) {

    $item_id = $_POST['updateItem'];

    //echo "test";

    if (!empty($_POST['update_name'])) {

        //echo "test";

        $new_name = $_POST['update_name'];

        $sql = "UPDATE inventory SET name = ? WHERE id = '$item_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "s", $param_update_name);

            $param_update_name = $new_name;

            mysqli_stmt_execute($query_stmt);

            header("location: inventory.php");
        }
    }

    if (!empty($_POST['update_serial_num'])) {

        //echo "test";

        $new_serialNum = $_POST['update_serial_num'];

        $sql = "UPDATE inventory SET serial_no = ? WHERE id = '$item_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "s", $param_update_serialNum);

            $param_update_serialNum = $new_serialNum;

            mysqli_stmt_execute($query_stmt);

            header("location: inventory.php");
        }
    }
    if (!empty($_POST['update_quantity'])) {

        //echo "test";

        $new_quantity = $_POST['update_quantity'];

        $sql = "UPDATE inventory SET quantity = ? WHERE id = '$item_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "s", $param_update_quantity);

            $param_update_quantity = $new_quantity;

            mysqli_stmt_execute($query_stmt);

            header("location: inventory.php");
        }
    }

    if (!empty($_POST['update_price'])) {

        //echo "test";

        $new_price = $_POST['update_price'];

        $sql = "UPDATE inventory SET price = ? WHERE id = '$item_id'";

        if ($query_stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($query_stmt, "s", $param_update_price);

            $param_update_price = $new_price;

            mysqli_stmt_execute($query_stmt);

            header("location: inventory.php");
        }
    }
}


// display product details from db
$get_inventory = "SELECT id, image, brand, name, serial_no, quantity, price FROM inventory";
$result = mysqli_query($conn, $get_inventory);

/* if (!empty($_GET['id'])) {
  //DB details
  //$dbHost     = 'localhost';
  //$dbUsername = 'root';
  //$dbPassword = '*****';
  //$dbName     = 'codexworld';
  //Create connection and select DB
  //$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
  //Check connection
  if ($conn->connect_error) {
  die("Connection failed: " . $db->connect_error);
  }

  //Get image data from database
  $result = $conn->query("SELECT image, brand, name, serial_no, quantity, price FROM inventory WHERE id = {$_GET['id']}");

  if ($result->num_rows > 0) {
  $imgData = $result->fetch_assoc();

  //Render image
  header("Content-type: image/jpg");
  echo $imgData['image'];
  } else {
  echo 'Image not found...';
  }
  } */
?>

<!DOCTYPE html>
<html>

    <head>

        <title>Admin - Main Page</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- for responsive page? -->

        <link rel="stylesheet" type="text/css" href="css/style_inventory.css"> 
        <!-- <link rel="stylesheet" type="text/css" href="css/form_style.css"> -->

    </head>

    <body>

        <ul class="topnav">
            <li><a  href="admin_home.php">Home</a></li> 
            <!--<li><a href="admin_profile.php">Admin Profile</a></li>-->
            <li><a class="active" href="inventory.php">Inventory</a></li> <!-- Add Menu, Update/Delete Menu-->
            <li><a href="user_order.php">Orders</a></li>
            <li><a href="sales_report.php">Sales Report</a></li>
            <!-- <li><a onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;">Login</a></li>
            <li><a onclick="document.getElementById('id02').style.display = 'block'" style="width:auto;">Register</a></li> -->
            <li><a href="logout.php">Logout</a></li>
            <!-- <li class="right"><a href="#about">Logout</a></li> -->
        </ul>

       <!-- <p><input type="file"  accept="image/*" name="image" id="file"  onchange="loadFile(event)" style="display: none;"></p>
        <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
        <p><img id="output" width="200" /></p> -->

        <!-- <header class="bgimg" style="position: relative;"></header> -->

        <div class="header">
            <h2>Add Inventory</h2>
        </div>

        <div class="upload-form">
            <form action="inventory.php" method="post" enctype="multipart/form-data">

                <div class="imgcontainer">
                    <!--<span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                    <img src="img/avatar.png" alt="Avatar" class="avatar"> -->
                </div>


                <!-- <input type="submit" name="btn_upload" value="UPLOAD"/> -->

                <div class="container">
                    <p><img class ="upload-image" id="output" width="200" /></p>                 
                    <p><input type="file"  accept="image/*" name="image" id="file"  onchange="loadFile(event)" style="display: none;" align="center"></p>
                    <p style="text-align: center;" ><label for="file" style="cursor: pointer;">Click Here to Upload Image</label></p>

                    <!-- <label for="lbl_select_img"><b>Select image to upload:</b></label>
                     <input type="file" name="image"/> -->

                    <br>
                    <br>
                    <br>

                    <label for="lbl_brand"><b>Brand:</b></label>
                    <input type="text" placeholder="Enter Brand" name="brand" > <!-- required -->

                    <label for="lbl_name"><b>Name:</b></label>
                    <input type="text" placeholder="Enter Name" name="name" >

                    <label for="lbl_serialNo"><b>Serial No:</b></label>
                    <input type="text" placeholder="Enter Serial No" name="serial_no" > <!-- required -->

                    <!--<label for="lbl_size"><b>Size:</b></label>
                    <input type="text" placeholder="Enter Size" name="size" > -->

                    <label for="lbl_quantity"><b>Quantity:</b></label>
                    <input type="text" placeholder="Enter Quantity" name="quantity" >

                    <label for="lbl_price"><b>Price(RM):</b></label>
                    <input type="text" placeholder="Enter Price" name="price" >

                    <button type="submit" name="btn_upload" >Upload</button>

                </div>
            </form>
        </div>

        <br>
        <br>

        <hr class="rounded"> <!-- html css line divider-->

        <br>
        <br>

        <form action="inventory.php" method="post" enctype="multipart/form-data"> <!-- enctype="image/jpg" -->

            <table class="card" align="center" border="1px solid white" style="width:1200px; line-height:40px; border-collapse: collapse;"> <!-- border-spacing: 0; border-collapse: separate; border-collapse: collapse; border-radius: 25px; -->
                <!-- style="border-collapse: collapse; border-radius: 30px; border-style: hidden; box-shadow: 0 0 0 1px #666;" -->
                <th>Id</th>
                <th>Image</th>
                <th>Brand</th>
                <th>Name</th>
                <th>Serial Number</th>
                <th>Quantity</th>
                <th>Price(RM)</th>
                <th>Update</th>
                <th>Delete</th>
                



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
                        <td align="center"><?php echo $rows['serial_no']; ?></td>
                        <td align="center"><?php echo $rows['quantity']; ?></td>
                        <td align="center"><?php echo $rows['price']; ?></td>
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #006200; color: white;" name="updateItem" value="' . $rows['id'] . '">Update</button> ' ?></td>
                        <td align="center"><?php echo '<button type="submit" style="inline; height:50px; width:125px; background-color: #d80000; color: white;" name="deleteItem" value="' . $rows['id'] . '">Delete</button> ' ?></td>
                        
                    </tr>
                    <?php
                }
                ?>
            </table>     


            <div class="update-form">

                <h4 style="text-align: center; color:white;">Update Form</h4>
                <input type="text" name="update_name" placeholder="Update Name" >
                <input type="text" name="update_serial_num" placeholder="Update Serial Number" > <!-- required -->
                <input type="text" name="update_quantity" placeholder="Update Quantity" >
                <input type="text" name="update_price" placeholder="Update Price"  >
            </div>


        </form>



        <!--<div class="update-form-header">
            <h4>Update Form</h4>
        </div>-->

        <p>Update status: Out of stock / In stock?</p>

        <script>
            var loadFile = function (event) {
                var image = document.getElementById('output');
                image.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
    </body>
</html>
