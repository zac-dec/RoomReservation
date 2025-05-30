<?php
// Include database connection
$conn = mysqli_connect('localhost', 'root', '', 'room_reservation');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php'); // Redirect if not logged in
    exit();
}

$room_id = $_GET['room_id'] ?? null;

if (!$room_id) {
    echo "Room ID is required.";
    exit();
}

// Fetch room details
$room_query = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$room_query->bind_param("i", $room_id);
$room_query->execute();
$room_details = $room_query->get_result()->fetch_assoc();

// Fetch existing reviews
$reviews_query = $conn->prepare(
    "SELECT r.review, u.username 
     FROM review r 
     JOIN login u ON r.login_id = u.id 
     WHERE r.room_id = ? 
     AND r.review IS NOT NULL 
     ORDER BY r.id ASC" // Order reviews by ID to display them sequentially
);
$reviews_query->bind_param("i", $room_id);
$reviews_query->execute();
$reviews_result = $reviews_query->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Reviews</title>
    <link rel="stylesheet" href="../assets/des.css"> <!-- Add your CSS file -->
</head>
<body>

<div class="review-container">
    <a href="review.php"><img src="../assets/back.png" alt="Logo" class="icon-button"></a>
    <h1><?php echo htmlspecialchars($room_details['name']); ?> Reviews</h1>

     <div class="user-side-nav">
    <img src="../assets/hotel.png" alt="Logo" style="width:85px; height: 75px; padding-top: 20px; padding: 10px; margin: 10px;">
    
    <a href="dashboard.php">Rooms</a>
    <a href="profile.php">Profile</a>
    <a href="review.php">Review</a>
    <a href="../logout.php">Log out</a>
    </div>
    <!-- Reviews Section -->
    <div class="reviews-container">
        <h2>Existing Reviews:</h2>
        <div class="chat-box">
            <?php if ($reviews_result->num_rows > 0): ?>
                <?php while ($review = $reviews_result->fetch_assoc()): ?>
                    <div class="review-item">
                        <p><strong style="margin-right: 45px"><?php echo htmlspecialchars($review['username']); ?>:</strong> <?php echo htmlspecialchars($review['review']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Review Form -->
    <h2>Add Your Review:</h2>
  <!-- Submit Review Form -->
<form method="POST" action="../config.php">
    <input type="hidden" name="action" value="submitReview"> <!-- Identify action -->
    <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
    <div class="form-group">
        <textarea name="content" placeholder="Write your review here..." required></textarea>
    </div>
    <button type="submit" class="submit-button" name="sbmtreview">Submit Review</button>
</form>




</body>
</html>
