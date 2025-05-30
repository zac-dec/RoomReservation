<?php  
    $conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
    session_start();
    error_reporting(1);

    if (isset($_SESSION['id'])) {
        #echo "Login ID: " . $_SESSION['id'];
    } else {
        #echo "No session started.";
        header('location:index.php');
    }

    if ($_SESSION['id'] != 1) {
        echo "<script>alert('Restricted area.');</script>";
        echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
        exit();
    }

    // Fetch room statuses
    $totalRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM rooms"))['total'];
    $activeRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as active FROM rooms WHERE room_status_id = 1"))['active'];
    $inactiveRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as inactive FROM rooms WHERE room_status_id = 2"))['inactive'];
    $maintenanceRooms = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as maintenance FROM rooms WHERE room_status_id = 3"))['maintenance'];

    // Calculate percentages
    $activePercentage = ($totalRooms > 0) ? ($activeRooms / $totalRooms) * 100 : 0;
    $inactivePercentage = ($totalRooms > 0) ? ($inactiveRooms / $totalRooms) * 100 : 0;
    $maintenancePercentage = ($totalRooms > 0) ? ($maintenanceRooms / $totalRooms) * 100 : 0;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Dashboard</title>
	<link rel="icon" type="image/x-icon" href="../assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="../assets/des.css">
    <style>
        
    </style>
</head>
<body>
    
    <audio src="../assets/ong.mp3" autoplay loop></audio>
    <div class="admin-main">
        <div class="admin-box">
            <img src="../assets/owner.png" alt="Logo" width="75px" height="75px" class="">
            <h1>Hello, Admin!</h1>

            <!-- Progress Bars -->
            <div class="progress-bar-container">
                <div class="progress-bar active-progress" style="width: <?= $activePercentage ?>%;">
                    <?= round($activePercentage) ?>%
                </div>
            </div>
            <div class="status-label">Active Rooms: <?= $activeRooms ?> / <?= $totalRooms ?></div>

            <div class="progress-bar-container">
                <div class="progress-bar inactive-progress" style="width: <?= $inactivePercentage ?>%;">
                    <?= round($inactivePercentage) ?>%
                </div>
            </div>
            <div class="status-label">Inactive Rooms: <?= $inactiveRooms ?> / <?= $totalRooms ?></div>

            <div class="progress-bar-container">
                <div class="progress-bar maintenance-progress" style="width: <?= $maintenancePercentage ?>%;">
                    <?= round($maintenancePercentage) ?>%
                </div>
            </div>
            <div class="status-label">Rooms in Maintenance: <?= $maintenanceRooms ?> / <?= $totalRooms ?></div>
        </div>

        <div class="admin-room-box">
            <a href="add_room.php" class="admin-buttons">Add Room</a>
            <a href="manage_rooms.php" class="admin-buttons">Manage Rooms</a>
            <a href="../logout.php" class="admin-buttons">Logout</a>
            <div class="admin-room-container">
    <h2>Current Rooms</h2>
    <table>
        <thead>
            <tr>
                <th>Room</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch room data from the database
            $rooms_query = mysqli_query($conn, "SELECT r.name, r.description, ra.name AS status 
                                                FROM rooms r
                                                JOIN room_status ra ON r.room_status_id = ra.id");

            while ($room = mysqli_fetch_assoc($rooms_query)) {
                echo "<tr>
                        <td>" . htmlspecialchars($room['name']) . "</td>
                        <td>" . htmlspecialchars($room['description']) . "</td>
                        <td>" . htmlspecialchars($room['status']) . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

        </div>
    </div>
</body>
</html>
