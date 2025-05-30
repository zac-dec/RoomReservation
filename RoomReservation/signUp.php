<!DOCTYPE html>
<html lang="en">
<head>
    <title>NGARAN IYO HOTEL OR RENTAHAN</title> <!-- balyue nala ngan remove ine na comment-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="assets/des.css">
    
</head>
<body>
	<audio src="assets/ong.mp3" autoplay loop></audio>

	<div class="login-container">
	    
	    <form action="config.php" method="POST" class="login-form">
	    	<h2 class="mb-4">SIGN UP / LOGIN</h2>

	    	<div class="form-group">
	        	<label for="username">Username: </label>
	        	<input type="text" id="username" name="username" placeholder="Enter Username"required>
	    	</div>

	    	<div class="form-group">
		        <label for="password">Password: </label>
		        <input id="password-field" name="pw" type="password" placeholder="Enter Password"required>
		    </div>

	        <div class="form-group">
		        <label for="confirm">Confirm Password: </label>
		        <input id="confirm" name="confirm" type="password" placeholder="Confirm Password"required>
		    </div>

	        <input type="submit" name="register" value="Register" class="login-button">
	    </form>

	    <div class="signup">
		    <hr>
		    <p>Already an existing member? <a href="index.php" class="signup-link">Log in here</a></p>
		</div>
	</div>
   
</body>
</html>
