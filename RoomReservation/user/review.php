<?php  
	$conn = mysqli_connect('localhost','root','','room_reservation');
	session_start();
	error_reporting(1);

	$id = $_SESSION['id'];

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
		    <a href="review.php">Review</a>
		    <a href="../logout.php">Log out</a>
        </div>

    <?php
    $sql = mysqli_query($conn, "SELECT fname, lname FROM profile WHERE login_id = {$_SESSION['id']}");
    $fetch = mysqli_fetch_assoc($sql);
	    $fname = $fetch['fname'];
    ?>
    <div class="dashboard">
    <h1>Review Room</h1>

    <div class="form-group-add-room">
    <form class="search" method="GET" action="">
        <input type="text" name="search" placeholder="Enter a product" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button type="submit" name="search_btn" class="submit-button-dsh">Search</button>
    </form>
    

        <?php
$the_search = $_GET['search'];
$search_condition = $_GET['search'] != "" ? "AND r.name LIKE '%$the_search%'" : ""; // Ensure AND for proper filtering

// Modify the query to join with rooms table based on room_id
$sql = "SELECT r.room_id, r.review, rooms.img, rooms.name
        FROM review r
        LEFT JOIN rooms ON r.room_id = rooms.id 
        WHERE r.login_id = $id $search_condition
        GROUP BY r.room_id"; // Group by room_id to avoid duplicates


$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
?></div>
<div class="room-img-container">
<?php
while ($row = mysqli_fetch_assoc($result)) {
    $productId = $row['room_id']; // Assuming room_id is in the review table
    $image_path = $row['img'] ?? '../assets/default-room.jpg'; // Fallback to default image
    ?>
    <a href="write_review.php?room_id=<?php echo htmlspecialchars($productId); ?>" style="color: white; text-decoration: none;">
        <div class="room-containers">
            <img src="../<?php echo htmlspecialchars($image_path); ?>" alt="Room Image" width="100%" height="250px">
            <div class="name_n_button">
                <p class="name"><?php echo htmlspecialchars($row['name']); ?></p>
                <p class="name">(clck to rvw)</p>
                <form class="add-to-cart" method="POST" action="../config.php">
                    <input type="hidden" name="productId" value="<?php echo htmlspecialchars($productId); ?>">
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
</div>
</body>

</html>


