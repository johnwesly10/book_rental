<?php
include("db_connection.php");

// Ensure necessary columns exist in the table
$required_columns = ['approval_status', 'rental_status', 'return_date'];
foreach ($required_columns as $col) {
    $check_columns = $conn->query("SHOW COLUMNS FROM rentals LIKE '$col'");
    if ($check_columns->num_rows == 0) {
        die("Error: Column '$col' does not exist. Update your database.");
    }
}

// ✅ AUTO UPDATE: Mark overdue rentals
$conn->query("UPDATE rentals SET rental_status = 'overdue' 
              WHERE rental_status = 'on rented' AND return_date < CURDATE()");

// Fine settings
$fine_per_day = 10;

// Handle rental approval
if (isset($_GET['approve_id'])) {
    $approve_id = $conn->real_escape_string($_GET['approve_id']);
    $conn->query("UPDATE rentals SET approval_status = 'approved', rental_status = 'on rented' WHERE rental_id = '$approve_id'");
}

// Handle rental rejection
if (isset($_GET['reject_id'])) {
    $reject_id = $conn->real_escape_string($_GET['reject_id']);
    $conn->query("UPDATE rentals SET approval_status = 'rejected' WHERE rental_id = '$reject_id'");
}

// Handle rental return
if (isset($_GET['return_id'])) {
    $return_id = $conn->real_escape_string($_GET['return_id']);
    $conn->query("UPDATE rentals SET rental_status = 'returned' WHERE rental_id = '$return_id'");
}

// Fetch rentals including fine calculation for overdue books
$rentals_by_date = [];
$result = $conn->query("SELECT rentals.*, books.title, users.username, users.email, 
                        IF(rentals.rental_status = 'overdue', DATEDIFF(CURDATE(), rentals.return_date) * $fine_per_day, 0) AS fine_amount
                        FROM rentals 
                        JOIN books ON rentals.book_id = books.book_id 
                        JOIN users ON rentals.user_id = users.user_id
                        ORDER BY rental_date");

while ($row = $result->fetch_assoc()) {
    $rentals_by_date[$row['rental_date']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Rentals</title>
  <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

<header class="header">
  <h1>Manage Rentals</h1>
  <p>Approve or reject rental requests.</p>
</header>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">Dashboard</a>

    <div class="menu-item">
        <a href="#" id="manage-books">Manage Books</a>
        <div class="submenu">
            <a href="add_book.php">Add Books</a>
            <a href="edit_book.php">Edit Books</a>
            <a href="remove_book.php">Remove Books</a>
        </div>
    </div>
    <a href="manage_rentals.php">Manage Rents</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_feedback.php">Feedback</a>
    <a href="report.php">Report</a>
  </div>

<div class="container">
    <div class="main-content">
        <section class="rental-list">
            <h2>Rental Requests</h2>
            <?php foreach ($rentals_by_date as $date => $rentals): ?>
                <h3>Rental Date: <?php echo htmlspecialchars($date); ?></h3>
                <table border="1">
                    <tr>
                        <th>User</th>
                        <th>Book</th>
                        <th>Rental Date</th>
                        <th>Return Date</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Approval Status</th>
                        <th>Rental Status</th>
                        <th>Fine Amount</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($rentals as $rental): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rental['username'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($rental['title'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($rental['rental_date'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($rental['return_date'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($rental['email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($rental['phone_number'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($rental['address'] ?? ''); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($rental['approval_status'] ?? 'pending')); ?></td>
                            <td>
                                <?php
                                    $status = $rental['rental_status'] ?? 'pending';
                                    if ($status === 'on rented') {
                                        echo '<span style="color: green;">On Rented</span>';
                                    } elseif ($status === 'returned') {
                                        echo '<span style="color: blue;">Returned</span>';
                                    } elseif ($status === 'overdue') {
                                        echo '<span style="color: red; font-weight: bold;">Overdue</span>';
                                    } else {
                                        echo ucfirst(htmlspecialchars($status));
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo ($rental['rental_status'] == 'overdue') 
                                      ? "<span style='color: red;'>₹" . htmlspecialchars($rental['fine_amount']) . "</span>" 
                                      : "No Fine";
                                ?>
                            </td>
                            <td>
                                <?php if (($rental['approval_status'] ?? '') == 'pending'): ?>
                                    <a href="?approve_id=<?php echo $rental['rental_id']; ?>" class="btn btn-approve">Approve</a>
                                    <a href="?reject_id=<?php echo $rental['rental_id']; ?>" class="btn btn-reject">Reject</a>
                                <?php elseif (($rental['approval_status'] ?? '') == 'approved' && ($rental['rental_status'] ?? '') == 'on rented'): ?>
                                    <a href="?return_id=<?php echo $rental['rental_id']; ?>" class="btn btn-return">Mark as Returned</a>
                                <?php elseif (($rental['approval_status'] ?? '') == 'approved' && ($rental['rental_status'] ?? '') == 'overdue'): ?>
                                    <span style="color: red; font-weight: bold;"></span> 
                                    <a href="?return_id=<?php echo $rental['rental_id']; ?>" class="btn btn-return">Mark as Returned</a>
                                <?php elseif (($rental['approval_status'] ?? '') == 'approved' && ($rental['rental_status'] ?? '') == 'returned'): ?>
                                    <span style="color: blue;">Returned</span>
                                <?php else: ?>
                                    <span style="color: red;">Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        </section>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
