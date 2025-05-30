<?php
    $conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
    session_start();
    error_reporting(1);
    if (isset($_SESSION['id'])) {
        #echo "Login ID: " . $_SESSION['id'];
    } else {
        #echo "No session started.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ROOM RESERV SYSTEM</title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="assets/des.css">

</head>
<body style="background-image: url('assets/bg.jpg'); background-repeat: none;
background-size: 100% 100%;">
    

    <div class="login-container">
        <img src="assets/logo.png" style="width:200px; height:200px; margin-left: 100px;">
        <form class="login-form" method="POST" action="config.php">
          <h2>LOGIN / SIGN UP</h2>
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your Username" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>
          </div>
          <button type="submit" class="login-button" name="login">Log in</button>
          <div class="signup">
            <hr>
            <p>Don't have an account? <a href="sign-up.php" class="signup-link">Sign up here</span></p>
          </div>
        </form>
    </div>
            
</body>
</html>
