<?php
// include "db/dbConfig.php";
// Initialize the session
session_start();
// timer for session ends --> user inactive on page

/* if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: user_home.php");
  exit;
  } */

$username = $password = "";
$username_err = $password_err = "";

$errors = array();

// Processing form data when form is submitted
if (isset($_POST['btn_login']) ) { //  $_SERVER["REQUEST_METHOD"] == "POST"

    // Check if username is empty
    if (empty(($_POST["username"]))) { // trim($_POST["uname"])
        // $username_err = "Please enter username.";
        array_push($errors, "Please enter username.");
    } else {
        $username = $_POST["username"]; // trim($_POST["uname"])
    }

    // Check if password is empty
    if (empty(($_POST["password"]))) { // trim($_POST["psw"])
        // $password_err = "Please enter your password.";
        array_push($errors, "Please enter your password.");
    } else {
        $password = $_POST["password"]; // trim($_POST["psw"])
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, name, password, user_type FROM user_info WHERE name = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    // mysqli_stmt_bind_result($stmt, $User_id, $User_username, $hashed_password);

                    $stmt->bind_result($bind_id, $bind_username, $bind_password, $bind_usertype);



                    if (mysqli_stmt_fetch($stmt)) { // $stmt->fetch()
                        if ($password == $bind_password && $bind_usertype == "user") { // password_verify($User_password, $hashed_password)
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: user_home.php");
                        } else if ($password == $bind_password && $bind_usertype == "admin") {

                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: admin_home.php");
                        } else {
                            // Display an error message if password is not valid
                            // $User_password_err = "The password you entered was not valid.";
                            // echo "The password you entered was not valid.";
                            // echo $hashed_password;
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    //$username_err = "No account found with that username.";
                    array_push($errors, "No account found with that username.");
                    
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    // mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

    <head>

        <title></title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/indexStyle.css">
        <link rel="stylesheet" type="text/css" href="css/form_style.css">


    </head>

    <body>

        <!-- <ul class="topnav">
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="#news">About Us</a></li>
            
            
            <li><a onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;">Login</a></li>
            <li><a onclick="document.getElementById('id02').style.display = 'block'" style="width:auto;">Register</a></li>
            
        </ul>

        <header class="bgimg" style="position: relative;"></header> -->

        <div id="id01" class="modal" >

            <form class="modal-content animate" action="index.php" method="post" >

                <?php include('errors.php'); ?>

                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                    <img src="img/avatar.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="username" > <!-- required -->

                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" > <!-- required -->

                    <button type="submit" name="btn_login" >Login</button>
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id01').style.display = 'none'" class="cancelbtn">Cancel</button>
                    <span class="psw">Forgot <a href="#">password?</a></span>
                </div>

            </form>

        </div>

        <script src="js/form_modal.js"></script> 
        
      

        <script>

                        // Get the modal
                        /*var modal_01 = document.getElementById('id01');
                         // var modal_02 = document.getElementById('id02');
                         
                         // When the user clicks anywhere outside of the modal, close it
                         window.onclick = function (event) {
                         if (event.target == modal_01) {
                         modal_01.style.display = "none";
                         }
                         }*/
        </script>

    </body>


</html>

