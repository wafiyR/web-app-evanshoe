<?php
require_once "db/dbConfig.php";
include "login.php";
include "register.php";

// Initialize the session
// session_start();
?>

<!DOCTYPE html>
<html>

    <head>

        <title>Main Page</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- for responsive page? -->

        <link rel="stylesheet" type="text/css" href="css/index_style.css">
        <link rel="stylesheet" type="text/css" href="css/form_style.css">

    </head>

    <body>

        <ul class="topnav">
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a onclick="document.getElementById('id01').style.display = 'block'" style="width:auto;">Login</a></li>
            <li><a onclick="document.getElementById('id02').style.display = 'block'" style="width:auto;">Register</a></li>
            <!-- <li class="right"><a href="#about">Logout</a></li> -->
        </ul>

        <header class="bgimg" style="position: relative;"></header>

        <!--<h1 style="color: white; text-align: center; position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%);">Evan's Shoes</h1>-->

        <br><br><br>

        <h1 id="about" style="text-align: center;">About Us</h1>

        <div>
            <p style="height: 10em; display: flex; align-items: center; justify-content: center;">Evan's Shoes was founded in blabla by Evan in lorem ipsum dolor sit amet, consectetur adipiscing elit,<br> sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris <br> nisi ut aliquip ex ea commodo consequat.</p> 
            <p style="height: 10em; display: flex; align-items: center; justify-content: center;">Evan's Shoes is located at blabla Kuala Lumpur in lorem ipsum dolor sit amet, consectetur adipiscing elit,<br> sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris <br> nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        
        <br> <br> <br>


        <h1 id="contact" style="text-align: center;">Contact Us</h1>

        <!--<div id="contact">
            <p style="height: 10em; display: flex; align-items: center; justify-content: center;">Evan's Shoes was founded in blabla by Evan in lorem ipsum dolor sit amet, consectetur adipiscing elit,<br> sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris <br> nisi ut aliquip ex ea commodo consequat.</p>            
        </div> -->

        <div class="container">
            <div style="text-align:center">
                <!--<h2>Contact Us</h2>-->
                <p>Swing by for a cup of coffee, or contact us:</p>
            </div>
            <div class="row">
                <div class="column">
                    <img src="img/map.png" style="width:100%">
                </div>
                <div class="column">
                    <form action="/action_page.php">
                        <label for="fname"><h3>Phone Number:</h3></label>
                        
                        <p style="font-size: 25px;">0123456789</p>
                        
                        <br>   
                        <!--<input type="text" id="fname" name="firstname" placeholder="Your name..">-->
                        <label for="lname"><h3>Office Number:</h3></label>
                        
                        <p style="font-size: 25px;">063208420</p>
                        
                        <br> 
                        <!--<input type="text" id="lname" name="lastname" placeholder="Your last name..">-->
                        <label for="lname"><h3>Instagram:</h3></label>
                        
                        <p style="font-size: 25px;">@evanshoes</p>
                        
                        <br>  
                        
                        <label for="lname"><h3>Address:</h3></label>
                        <p style="font-size: 25px;">G45, Suria KLCC, Kuala Lumpur, Malaysia</p>
                        <!--<label for="country">Country</label>
                        <select id="country" name="country">
                            <option value="australia">Australia</option>
                            <option value="canada">Canada</option>
                            <option value="usa">USA</option>
                        </select>
                        <label for="subject">Subject</label>
                        <textarea id="subject" name="subject" placeholder="Write something.." style="height:170px"></textarea>
                        <input type="submit" value="Submit">-->
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
