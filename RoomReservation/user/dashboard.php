<?php 


    date_default_timezone_set('Asia/Manila');


	$conn = mysqli_connect('localhost','root','','room_reservation');
	session_start();
	error_reporting(1);

    if(isset($_SESSION['id'])) {
        #echo "Login ID: " . $_SESSION['id'];
    } else {
        #echo "No session started.";
        header('location:index.php');
    }

    if($_SESSION['id'] == 1) {
		echo "<script>alert('Restricted area.');</script>";
	    echo '<meta http-equiv="refresh" content="0;url=admin.php">';
	exit();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ROOM RESERVATION</title>
    <link rel="icon" type="image/x-icon" href="../assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="../assets/des.css">
</head>

<body>

        <div class="user-side-nav">
			<img src="../assets/hotel.png" alt="Logo" style="width:85px; height: 75px; padding-top: 20px; padding: 10px; margin: 10px;">
    
		    <a href="dashboard.php">Rooms</a>
		    <a href="profile.php">Profile</a>
            <a href="booked_rooms.php">Books</a>
		    <a href="review.php">Review</a>
		    <a href="../logout.php">Log out</a>
        </div>

    <?php
    $sql = mysqli_query($conn, "SELECT fname, lname FROM profile WHERE login_id = {$_SESSION['id']}");
    $fetch = mysqli_fetch_assoc($sql);
	    $fname = $fetch['fname'];
    ?>
    <div class="dashboard">
    <h1>Hello, <?php echo $fname; ?>!</h1>

    <div class="form-group-add-room">
    <form class="search" method="GET" action="">
        <input type="text" name="search" placeholder="Search a room" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" name="search_btn" class="submit-button-dsh">Search</button>
    </form>

        <?php
// Set up the search condition
$searchCondition = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
    $searchCondition = "AND name LIKE '%$searchQuery%'";
}

// Current time in 'H:i:s' format
$current_time = date('H:i:s');

// Fetch rooms that match the current time threshold and search condition
$sql = "SELECT * FROM rooms 
        WHERE room_status_id = 1 
        AND open_in <= '$current_time' 
        AND close_in >= '$current_time' 
        $searchCondition";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
?>

    </div>
    <div class="form-group-add-room" style="background-color: gray;">
        <h1>Available Rooms</h1>
    </div>
        <div class="room-img-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row['id'];
            ?>
     
        	<a href="room_dtls.php?room_id=<?php echo $productId ?>" style="color: white; text-decoration: none;">

            <div class="room-containers">
                <img src="../<?php echo $row['img']; ?>" alt="Product Image" width="100%" height="250px">
                <div class="name_n_button">
                <p class="name"><?php echo $row['name']; ?></p>
       			<p class="name">(clck for dtls)</p>
                    <form class="add-to-cart" method="POST" action="config.php">
                       
                        <input type="hidden" name="productId" value="<?php echo $productId; ?>">

                    
                    </form>

     			 </div>
     			 </a>
     			</div>
     		
            <?php
        }
        ?>

        </div>
</div>
</div>
</body>

</html>


