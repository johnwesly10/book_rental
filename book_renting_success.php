<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['rental_success']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$rental_id = $_SESSION['rental_success']['rental_id'] ?? '';
$book_id = $_SESSION['rental_success']['book_id'] ?? '';
$user_id = $_SESSION['user_id'];

// Fetch rental details
$stmt = $conn->prepare("
    SELECT r.rental_id, r.rental_date, r.return_date, r.address, r.approval_status, r.rental_status,
           b.title, b.rent_amount,
           u.username, u.email, u.phone_number
    FROM rentals r 
    JOIN books b ON r.book_id = b.book_id 
    JOIN users u ON r.user_id = u.user_id 
    WHERE r.rental_id = ? AND r.user_id = ?
");
$stmt->bind_param("ii", $rental_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit();
}

$rental = $result->fetch_assoc();

// Clear the success session data after fetching
unset($_SESSION['rental_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Success - Book Rental System</title>
    <link rel="stylesheet" href="css/book_renting_success.css">
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <img src="images/success-icon.png" alt="Book Rental Success" width="80" height="80">
        </div>
        
        <h1 class="success-title">Book Rented Successfully!</h1>
        
        <div class="rental-details">
            <div class="detail-row">
                <span class="detail-label">Book Title:</span>
                <span class="detail-value"><?php echo htmlspecialchars($rental['title']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Rental Date:</span>
                <span class="detail-value"><?php echo date('F j, Y', strtotime($rental['rental_date'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Return Date:</span>
                <span class="detail-value"><?php echo date('F j, Y', strtotime($rental['return_date'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount Paid:</span>
                <span class="detail-value">₹<?php echo number_format($rental['rent_amount'], 2); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Delivery Address:</span>
                <span class="detail-value"><?php echo htmlspecialchars($rental['address']); ?></span>
            </div>
        </div>

        <div class="buttons">
            <a href="book-images.php" class="btn btn-primary">Rent Another Book</a>
            <a href="rental_status.php" class="btn btn-secondary">rRental Status</a>
        </div>
    </div>
</body>
</html>
