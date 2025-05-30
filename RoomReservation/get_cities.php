<?php
$conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
if (!$conn) {
    die(json_encode(['error' => 'Database connection failed.']));
}

if (isset($_GET['province_id'])) {
    $province_id = intval($_GET['province_id']); // Sanitize input
    $sql = $conn->prepare("SELECT id, name FROM city WHERE province_id = ?");
    $sql->bind_param("i", $province_id);
    $sql->execute();
    $result = $sql->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }

    echo json_encode($cities);
} else {
    echo json_encode(['error' => 'No province_id provided.']);
}
?>
