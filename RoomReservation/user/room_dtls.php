<?php  
$conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
session_start();
error_reporting(1);

$id = $_SESSION['id'];

if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']); // Sanitize input
    $room_query = mysqli_query($conn, "SELECT * FROM rooms WHERE id = $room_id");
    $room_details = mysqli_fetch_assoc($room_query);
    if (!$room_details) {
        echo "<script>alert('Room not found.');</script>";
        echo '<meta http-equiv="refresh" content="0;url=manage_rooms.php">';
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect updated data
    $name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $floor = intval($_POST['floor']);
    $type = intval($_POST['type']);
    $price = floatval($_POST['price']);
    $features = isset($_POST['room_feature']) ? $_POST['room_feature'] : [];
 }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>
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
    <audio src="../assets/song.mp3" autoplay loop></audio>
    <div class="details_room">
        <a href="dashboard.php"><img src="../assets/back.png" alt="Back" class="icon-button"></a>
        <h2>Room Details</h2>


        	 <div class="form-group-add-room">
     
                    <img src="../<?= htmlspecialchars($room_details['img']) ?>" alt="Current Room Image" style="width: 120px; height: 120px; display: block; margin-right: 10px;">
            </div>

            <div class="form-group-add-room">
                <label for="room_name">Room Name:</label>
                <p><?= htmlspecialchars($room_details['name']) ?></p>
            </div>

           


            <div class="form-group-add-room">
                <label for="desc">Room Description:</label>
                <p><?= htmlspecialchars($room_details['description']) ?></p>
            </div>

          

            <div class="form-group-add-room">
                <label for="floor">Room Floor:</label>
                <p>
                     <?php
				        // Assuming $room_details contains information about the current room
				        $roomFloorId = $room_details['room_floor_id'];

				        // Fetching the floor name based on room_floor_id
				        $floor_query = mysqli_query($conn, "SELECT name FROM room_floor WHERE id = $roomFloorId");
				        
				        if ($floor_row = mysqli_fetch_assoc($floor_query)) {
				            echo htmlspecialchars($floor_row['name']); // Displaying the floor name safely
				        } else {
				            echo "Floor not found"; // Handle case where no floor is found
				        }
				        ?>
                </select>
            </div>

            <div class="form-group-add-room">
                <label for="type">Room Type:</label>
                <p>
                   <?php
				        // Assuming $room_details contains information about the current room
				        $roomAvailability = $room_details['room_type_id'];

				        // Fetching the floor name based on room_floor_id
				        $floor_query = mysqli_query($conn, "SELECT name FROM room_type WHERE id = $roomAvailability");
				        
				        if ($floor_row = mysqli_fetch_assoc($floor_query)) {
				            echo htmlspecialchars($floor_row['name']); // Displaying the floor name safely
				        } else {
				            echo "Type not found"; // Handle case where no floor is found
				        }
				        ?>
                </p>
            </div>

            <div class="form-group-add-room">
                <label for="features">Features:</label>
				<div class="checkbox-grid">
				    <?php
				    // Fetch all features
				    $feature_query = mysqli_query($conn, "SELECT * FROM room_feature");
				    
				    // Fetch features associated with the specific room
				    $room_features_query = mysqli_query($conn, "SELECT room_feature_id FROM room_features WHERE rooms_id = $room_id");
				    $room_features = array_column(mysqli_fetch_all($room_features_query, MYSQLI_ASSOC), 'room_feature_id');

				    // Loop through each feature and display it as a read-only checkbox
				    while ($row = mysqli_fetch_assoc($feature_query)) {
				        $checked = in_array($row['id'], $room_features) ? "checked" : "";
				        echo "<label><input type='checkbox' name='room_feature[]' value='{$row['id']}' $checked disabled> {$row['name']}</label><br>";
				    }
				    ?>
				</div>

            </div>

            <div class="form-group-add-room">
                <label for="price">Minimum/Price per hour:</label>
                <p>₱ <?= htmlspecialchars($room_details['price']) ?></p>
            </div>
            
            <form method="POST" action="../config.php">
               	<input type="text" name="login_id" value="<?php echo $id ?>" hidden>
                <input type="text" name="room_id" value="<?php echo $room_id ?>" hidden>
                <input type="submit" value="Book this room now!" class="submit-button" name="book">
            </form>
    </div>
</body>
</html>
