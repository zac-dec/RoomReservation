<?php  
$conn = mysqli_connect('localhost','root','','room_reservation');
session_start();
error_reporting(1);

if(isset($_SESSION['id'])) {
    // User is logged in
} else {
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="icon" type="image/x-icon" href="../assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="../assets/des.css">
</head>
<body>

<div class="manage-rooms-container">
    
    <a href="admin.php"><img src="../assets/back.png" alt="Logo" class="icon-button"></a>
    <h2>Manage Rooms</h2>

    <audio src="../assets/csong.mp3" autoplay loop></audio>


    <table>
        <tr>
            <th>IMG</th>
            <th>Name</th>
            <th>Description</th>
            <th>Availability</th>
            <th>Floor</th>
            <th>Type</th>
            <th>Price</th>
            <th style="width:9%">Features</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

    <?php
        $sql = "SELECT
                    r.name AS room_name,
                    r.id AS room_id,
                    r.img AS room_image,
                    r.description AS room_description,
                    r.open_in,
                    r.close_in,
                    rFlr.name AS floor_name,
                    r.price AS room_price,
                    rTyp.name AS type_name,
                    rS.name AS status
                FROM
                    rooms r
                INNER JOIN
                   	room_status rS ON rS.id = r.room_status_id
                INNER JOIN
                    room_floor rFlr ON r.room_floor_id = rFlr.id
                INNER JOIN
                    room_type rTyp ON r.room_type_id = rTyp.id
                GROUP BY
                    r.name, r.id, r.img, r.description, rFlr.name, r.price, rTyp.name;
            ";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Output data for each row
        while($row = mysqli_fetch_assoc($result)) {
            $productID = $row["room_id"];
            $name = $row["room_name"];
    ?>
        <tr>
    <form action="../config.php" method="POST">
        <input type="hidden" name="room_id" value="<?php echo $productID; ?>">
        <td><img src="../<?php echo $row["room_image"]; ?>" alt="Product Image" width="100px" height="100px"></td>
        <td>
            <div class="form-group-manage-room">
                <input type="text" name="room_name" value="<?php echo $name; ?>">
            </div>
        </td>
        <td style="max-width: 50px; overflow: hidden;"><?php echo $row["room_description"]; ?></td>
        <td><?php echo $row["open_in"]. ' - ' .$row["close_in"]; ?></td>
        <td><?php echo $row["floor_name"]; ?></td>
        <td><?php echo $row["type_name"]; ?></td>
        <td>
            <div class="form-group-manage-room">
                ₱<input type="text" name="room_price" value="<?php echo $row["room_price"]; ?>">
            </div>
        </td>
        <td>
            <?php
            $sizeStocks = mysqli_query($conn, "SELECT 
                r.name,
                rf.name AS feature_name
                FROM room_features rfs
                INNER JOIN rooms r ON r.id = rfs.rooms_id
                INNER JOIN room_feature rf ON rf.id = room_feature_id
                WHERE r.id = '$productID'
                GROUP BY rf.name;");
            while ($fetch = mysqli_fetch_assoc($sizeStocks)) {
                $feature_name = $fetch['feature_name'];
                echo $feature_name . ' ';
            }
            ?>
        </td>
        <td>
            <div class="form-group-manage-room">
			    <select name="room_status" class="compact-select">
			        <?php
			        $sql = mysqli_query($conn, "SELECT * FROM room_status");
			        while ($fetch = mysqli_fetch_assoc($sql)) {
			            $id = $fetch['id'];
			            $cat = $fetch['name'];

			            // Check if this is the current status
			            if ($row['status'] == $cat) {
			                echo "<option value='$id' selected>$cat</option>";
			            } else {
			                echo "<option value='$id'>$cat</option>"; 
			            }
			        }
			        ?>
			    </select>
			</div>

        </td>
        <td>
            <div class="action">
            	<input type="submit" name="edit_room" value="Edit">
                <input type="submit" name="delete_room" value="Delete">
                <input type="submit" name="update_room" value="Update">
            </div>
        </td>
    </form>
</tr>

    
    <?php 
        } 
        } else {
            echo "No Rooms found";
        }   
        mysqli_close($conn);
    ?>
    
        </table>
</div>