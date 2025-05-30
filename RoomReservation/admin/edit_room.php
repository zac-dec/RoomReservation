<?php  
$conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
session_start();
error_reporting(1);

if (!isset($_SESSION['id']) || $_SESSION['id'] != 1) {
    header('Location: index.php');
    exit();
}

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
    $booking_duration = mysqli_real_escape_string($conn, $_POST['book_dur']);
    $availability = intval($_POST['availability']);
    $floor = intval($_POST['floor']);
    $type = intval($_POST['type']);
    $price = floatval($_POST['price']);
    $features = isset($_POST['room_feature']) ? $_POST['room_feature'] : [];
    
    $targetDirectory = "../assets/rooms/"; // For file system
    $image_base_url = "assets/rooms/";    // For URL path (browser-friendly)

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = $name . '.' . $fileExtension;

        $newImagePath = $targetDirectory . $newFileName; // Full file system path
        $newImageUrl = $image_base_url . $newFileName;   // Browser-accessible path

        if (move_uploaded_file($_FILES['image']['tmp_name'], $newImagePath)) {
            // Remove old image if it exists
            if (file_exists($room_details['img'])) {
                unlink($room_details['img']);
            }
            $image_path = $newImageUrl; // Store the URL-friendly path in the database
        } else {
            echo "<script>alert('Failed to upload the image. Please try again.');</script>";
        }
    }
    

    // Update room in database
    $update_query = "UPDATE rooms SET 
        name = '$name', 
        description = '$description', 
        booking_duration = '$booking_duration', 
        room_availability_id = $availability, 
        room_floor_id = $floor, 
        room_type_id = $type, 
        price = $price, 
        img = '$image_path' 
        WHERE id = $room_id";

    if (mysqli_query($conn, $update_query)) {
        // Update room features
        mysqli_query($conn, "DELETE FROM room_features WHERE rooms_id = $room_id");
        foreach ($features as $feature_id) {
            mysqli_query($conn, "INSERT INTO room_features (rooms_id, room_feature_id) VALUES ($room_id, $feature_id)");
        }

        echo "<script>alert('Room updated successfully!');</script>";
        echo '<meta http-equiv="refresh" content="0;url=manage_rooms.php">';
    } else {
        echo "Error updating room: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <link rel="icon" type="image/x-icon" href="../assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="../assets/des.css">
</head>
<body>
    <audio src="../assets/song.mp3" autoplay loop></audio>
    <div class="add-room-container">
        <a href="manage_rooms.php"><img src="../assets/back.png" alt="Back" class="icon-button"></a>
        <h2>Edit Room</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group-add-room">
                <label for="room_name">Room Name:</label>
                <input type="text" name="room_name" value="<?= htmlspecialchars($room_details['name']) ?>" required>
            </div>

            <div class="form-group-add-room">
                <label for="image">Current Room Photo:</label>
                <?php if (!empty($room_details['img'])): ?>
                    <!-- Display the current image -->
                    <img src="../<?= htmlspecialchars($room_details['img']) ?>" alt="Current Room Image" style="width: 30px; height: 30px; display: block; margin-right: 10px;">
                <?php else: ?>
                    <!-- Fallback if no image is uploaded -->
                    <p>No image uploaded yet.</p>
                <?php endif; ?>
                
                <label for="image">Upload New Photo:</label>
                <input type="file" name="image" accept="image/*">
            </div>


            <div class="form-group-add-room">
                <label for="desc">Room Description:</label>
                <input type="text" name="description" value="<?= htmlspecialchars($room_details['description']) ?>" required>
            </div>

            <div class="form-group-add-room">
                <label for="book_dur">Booking Duration:</label>
                <input type="text" name="book_dur" value="<?= htmlspecialchars($room_details['booking_duration']) ?>" required>
            </div>

            <div class="form-group-add-room">
                <label for="availability">Room Availability:</label>
                <select name="availability" required>
                    <?php
                    $availability_query = mysqli_query($conn, "SELECT * FROM room_availability");
                    while ($row = mysqli_fetch_assoc($availability_query)) {
                        $selected = $row['id'] == $room_details['room_availability_id'] ? "selected" : "";
                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-add-room">
                <label for="floor">Room Floor:</label>
                <select name="floor" required>
                    <?php
                    $floor_query = mysqli_query($conn, "SELECT * FROM room_floor");
                    while ($row = mysqli_fetch_assoc($floor_query)) {
                        $selected = $row['id'] == $room_details['room_floor_id'] ? "selected" : "";
                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-add-room">
                <label for="type">Room Type:</label>
                <select name="type" required>
                    <?php
                    $type_query = mysqli_query($conn, "SELECT * FROM room_type");
                    while ($row = mysqli_fetch_assoc($type_query)) {
                        $selected = $row['id'] == $room_details['room_type_id'] ? "selected" : "";
                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-add-room">
                <label for="features">Features:</label>
                <div class="checkbox-grid">
                    <?php
                    $feature_query = mysqli_query($conn, "SELECT * FROM room_feature");
                    $room_features_query = mysqli_query($conn, "SELECT room_feature_id FROM room_features WHERE rooms_id = $room_id");
                    $room_features = array_column(mysqli_fetch_all($room_features_query, MYSQLI_ASSOC), 'room_feature_id');

                    while ($row = mysqli_fetch_assoc($feature_query)) {
                        $checked = in_array($row['id'], $room_features) ? "checked" : "";
                        echo "<label><input type='checkbox' name='room_feature[]' value='{$row['id']}' $checked> {$row['name']}</label><br>";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group-add-room">
                <label for="price">Price:</label>
                <input type="text" name="price" value="<?= htmlspecialchars($room_details['price']) ?>" required>
            </div>

            <input type="submit" value="Save Changes" class="submit-button">
        </form>
    </div>
</body>
</html>
