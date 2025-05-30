<?php  
$conn = mysqli_connect('localhost','root','','room_reservation');
session_start();
error_reporting(1);

if(isset($_SESSION['id'])) {
    // User is logged in
} else {
    header('location:index.php');
}

if($_SESSION['id'] != 1) {
    echo "<script>alert('Restricted area.');</script>";
    echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="icon" type="image/x-icon" href="../assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="../assets/des.css">
</head>
<body>

<div class="add-room-container">
    
    <a href="admin.php"><img src="../assets/back.png" alt="Logo" class="icon-button"></a>
    <h2>Add Room</h2>

    <form method="POST" action="../config.php" enctype="multipart/form-data">

        <div class="form-group-add-room">
            <label for="room_name">Room Name:</label>
            <input type="text" name="room_name" placeholder="Enter Room Name" required>
        </div>

        <div class="form-group-add-room">
            <label for="image">Room Photo:</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-group-add-room">
            <label for="desc">Room Description:</label>
            <input type="text" name="description" placeholder="Enter room description" required>
        </div>

        <div class="form-group-add-room">
            <label for="open_in">Room Available From:</label>
            <input type="time" name="open_in" required>
            <label for="close_in">Room Available Until:</label>
            <input type="time" name="close_in" required>
        </div>

        <div class="form-group-add-room">
            <label for="floor">Room Floor:</label>
            <select name="floor" required class="compact-select">
                <option value="" disabled selected>Select One</option>
                <?php
                $sql = mysqli_query($conn, "SELECT * from room_floor");
                while ($fetch = mysqli_fetch_assoc($sql)) {
                    $id = $fetch['id'];
                    $cat = $fetch['name'];
                    echo "<option value='$id'>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group-add-room">
            <label for="type">Room Type:</label>
            <select name="type" required class="compact-select">
                <option value="" disabled selected>Select One</option>
                <?php
                $sql = mysqli_query($conn, "SELECT * from room_type");
                while ($fetch = mysqli_fetch_assoc($sql)) {
                    $id = $fetch['id'];
                    $cat = $fetch['name'];
                    echo "<option value='$id'>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group-add-room">
            <label for="features">Features:</label>
            <div class="checkbox-grid">
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM room_feature");
                while ($fetch = mysqli_fetch_assoc($sql)) {
                    $id = $fetch['id'];
                    $size = $fetch['name'];
                    echo "<label><input type='checkbox' name='room_feature[]' value='$id'> $size</label><br>";
                }
                ?>
            </div>
        </div>

        <div class="form-group-add-room">
            <label for="price">Price Per Hour:</label>
            <input type="text" id="price" name="price" placeholder="Enter new price" required>
        </div>

        <input type="submit" name="add_room" value="Add Room" class="submit-button">
    </form>
</div>

</body>
</html>