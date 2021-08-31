<?php
// include "db/dbConfig.php";
// Processing form data when form is submitted


/* if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: user_home.php");
  exit;
  } */



/* if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Define variables and initialize with empty values
  $email = $username = $password = "";
  $email_err = $username_err = $password_err = $c_password_err = "";

  // Check if email is empty
  if (empty(($_POST["email"]))) { //trim($_POST["email"])
  $email_err = "Please enter your email.";
  } else {

  // Prepare a SELECT statement
  $sql = "SELECT id FROM user_info WHERE email = ?";

  if ($stmt = mysqli_prepare($conn, $sql)) {
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "s", $param_useremail);

  // Set parameters
  $param_useremail = $_POST["email"];

  // Attempt to execute the prepared statement
  if (mysqli_stmt_execute($stmt)) {
  // store result
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) == 1) {
  $email_err = "This email is already taken.";

  //echo $email_err;
  } else {
  $email = $_POST["email"];
  }
  } else {
  echo "Oops! Something went wrong. Please try again later.";
  }

  // Close statement
  mysqli_stmt_close($stmt);
  }
  }

  // Check if username is empty
  if (empty(($_POST["username"]))) { // trim($_POST["uname"])
  $username_err = "Please enter username.";
  } else {
  // Prepare a SELECT statement
  $sql = "SELECT id FROM user_info WHERE name = ?";

  if ($stmt = mysqli_prepare($conn, $sql)) {
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "s", $param_username);

  // Set parameters
  $param_username = $_POST["username"];

  // Attempt to execute the prepared statement
  if (mysqli_stmt_execute($stmt)) {
  // store result
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) == 1) {
  $username_err = "This username is already taken.";

  //echo $username_err;
  } else {
  $username = $_POST["username"]; // trim($_POST["uname"])
  }
  } else {
  echo "Oops! Something went wrong. Please try again later.";
  }

  // Close statement
  mysqli_stmt_close($stmt);
  }
  }

  // Validate password
  if (empty(($_POST["password"]))) {  // trim($_POST["psw"])
  $password_err = "Please enter a password.";
  } else if (strlen(($_POST["password"])) < 6) { // trim($_POST["psw"])
  $password_err = "Password must have at least 6 characters.";

  //echo $password_err;
  } else {
  $password = $_POST["password"]; // trim($_POST["psw"])
  }

  // Validate confirm password
  if (empty(($_POST["c_password"]))) { //trim($_POST["psw_repeat"])
  $c_password_err = "Please confirm password.";
  } else {
  $c_password = $_POST["c_password"]; // trim($_POST["psw_repeat"])
  if (empty($password_err) && ($password != $c_password)) {
  $c_password_err = "Password did not match.";
  //echo $c_password_err;
  }
  }

  // Validate credentials
  if (empty($email_err) && empty($username_err) && empty($password_err) && empty($c_password_err)) { // typo empty($Usser_username_err)
  $user_type = "user";

  // Prepare a INSERT statement
  $sql = "INSERT INTO user_info ( email, name, password, user_type) VALUES (?, ?, ?, ?)";

  if ($stmt = mysqli_prepare($conn, $sql)) {
  // Bind variables to the prepared statement as parameters
  mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_username, $param_password, $param_usertype);

  // Set parameters
  $param_email = $email;

  $param_username = $username;
  // $param_password = password_hash($User_password, PASSWORD_DEFAULT); // Creates a password hash
  $param_password = $password;

  $param_usertype = $user_type;

  // Attempt to execute the prepared statement
  if (mysqli_stmt_execute($stmt)) {
  // Redirect to login page
  header("location: user_home.php");
  } else {
  echo "Oops! Something went wrong. Please try again later.";
  }

  // Close statement
  mysqli_stmt_close($stmt);
  }
  }

  // Close connection
  // mysqli_close($conn);
  } */

$email = $username = $password = $c_password = $user_type = "";

$email_err = $username_err = $password_err = "";

$errors = array();

if (isset($_POST['btn_register'])) { //   $_SERVER["REQUEST_METHOD"] == "POST"
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $c_password = $_POST["c_password"];
    $user_type = "user";

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (empty($c_password)) {
        array_push($errors, "Confirm password is required");
    }
    if (strlen($password) < 6) {
        array_push($errors, "Password must have at least 6 characters.");
    }
    if ($password != $c_password) {
        array_push($errors, "The two passwords did not match");
    }

// first check the database to make sure 
// a user does not already exist with the same username and/or email
    /* $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
      $result = mysqli_query($db, $user_check_query);
      $user = mysqli_fetch_assoc($result);

      if ($user) { // if user exists
      if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
      }

      if ($user['email'] === $email) {
      array_push($errors, "email already exists");
      }
      } */


    if (count($errors) == 0) {

        $query = "SELECT email, name FROM user_info WHERE email=? OR name=? LIMIT 1";

        if ($stmt = mysqli_prepare($conn, $query)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_username);

            // Set parameters
            $param_email = $email;
            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username or email exists, if yes then verify 
                if (mysqli_stmt_num_rows($stmt) == 1) {

                    // Bind result variables
                    $stmt->bind_result($bind_email, $bind_username);

                    if (mysqli_stmt_fetch($stmt)) {

                        if ($email == $bind_email) {
                            array_push($errors, "Email already exists");
                        }
                        if ($username == $bind_username) {
                            array_push($errors, "Username already exists");
                        }
                    }
                } else {
                    $sql = "INSERT INTO user_info (email, name, password, user_type) VALUES (?, ?, ?, ?)";

                    if ($stmt = mysqli_prepare($conn, $sql)) {

                        // $email = $_POST["email"];
                        // $username = $_POST["username"];
                        // $password = $_POST["password"];
                        // $user_type = "user";
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_username, $param_password, $param_usertype);

                        // Set parameters
                        $param_email = $email;
                        $param_username = $username;
                        // $param_password = password_hash($User_password, PASSWORD_DEFAULT); // Creates a password hash
                        $param_password = $password;
                        $param_usertype = $user_type;
                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {

                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;

                            // Redirect to login page
                            header("location: user_home.php");
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }

                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                }
            }
        }
    }

    /* if (count($errors) == 0) {

      $sql = "INSERT INTO user_info (email, name, password, user_type) VALUES (?, ?, ?, ?)";

      if ($stmt = mysqli_prepare($conn, $sql)) {

      // $email = $_POST["email"];
      // $username = $_POST["username"];
      // $password = $_POST["password"];
      // $user_type = "user";

      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $param_email, $param_username, $param_password, $param_usertype);

      // Set parameters
      $param_email = $email;
      $param_username = $username;
      // $param_password = password_hash($User_password, PASSWORD_DEFAULT); // Creates a password hash
      $param_password = $password;
      $param_usertype = $user_type;
      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
      // Redirect to login page
      header("location: user_home.php");
      } else {
      echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
      }
      } */
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
        <link rel="stylesheet" type="text/css" href="css/error.css">

    </head>

    <body>

        <!-- <ul class="topnav">
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="#news">About Us</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            
        </ul> 

        <header class="bgimg" style="position: relative;"></header> -->

        <div id="id02" class="modal">

            <form class="modal-content animate" action="index.php" method="post">

                <?php include('errors.php'); ?>

                <div class="imgcontainer">
                    <span onclick="document.getElementById('id02').style.display = 'none'" class="close" title="Close Modal">&times;</span>
                    <img src="img/avatar.png" alt="Avatar" class="avatar">
                </div>

                <div class="container">
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="username" ><!-- required -->

                    <label for="email"><b>Email</b></label>
                    <input type="text" placeholder="Enter Email" name="email" ><!-- required -->

                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="password" ><!-- required -->

                    <label for="c_password"><b>Confirm Password</b></label>
                    <input type="password" placeholder="Confirm Password" name="c_password" ><!-- required -->

                    <button type="submit" name="btn_register">Register</button>
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>

                <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id02').style.display = 'none'" class="cancelbtn">Cancel</button>
                    <span class="psw">Forgot <a href="#">password?</a></span>
                </div>

            </form>

        </div>

        <script src="js/form_modal.js"></script> 

        <script>

                        // Get the modal
                        /*var modal_02 = document.getElementById('id02');
                         // var modal_02 = document.getElementById('id02');
                         
                         // When the user clicks anywhere outside of the modal, close it
                         window.onclick = function (event) {
                         if (event.target == modal_02) {
                         modal_02.style.display = "none";
                         }
                         } */
        </script>

    </body>
</html>

