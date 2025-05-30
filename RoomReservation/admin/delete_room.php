<?php
$conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['room_id'])) {
    $room_id = intval($_GET['room_id']); // Sanitize input

    // SQL to delete the room
    $sql = "DELETE FROM rooms WHERE id = $room_id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Room deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting room: " . mysqli_error($conn) . "');</script>";
    }
}
echo "<script>window.location.href='manage_rooms.php';</script>";
?>
