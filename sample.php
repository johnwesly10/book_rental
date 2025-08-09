<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['user_id'])) {
  echo "<script>
      alert('Please log in to view your rental status.');
      window.location.href = 'login.php';
  </script>";
  exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Update overdue status & calculate fines
$fine_per_day = 10; // Set fine per day (₹10 per day after due date)
$conn->query("UPDATE rentals SET rental_status = 'overdue' 
              WHERE rental_status = 'on rented' AND return_date < CURDATE()");

// Fetch rentals with calculated fine for overdue books
$sql = "SELECT rentals.*, books.title, books.rent_amount, users.username, users.email, rentals.phone_number, rentals.address, rentals.approval_status, rentals.rental_status,
               IF(rentals.rental_status = 'overdue', DATEDIFF(CURDATE(), rentals.return_date) * $fine_per_day, 0) AS fine_amount
        FROM rentals 
        JOIN books ON rentals.book_id = books.book_id 
        JOIN users ON rentals.user_id = users.user_id
        WHERE rentals.user_id = '$user_id' 
        ORDER BY rentals.return_date ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rental Status</title>
  <link rel="stylesheet" href="sample.css">
</head>
<body>

  <header>
    <h1>Rental Status</h1>
    <p>Check if your rental request has been approved or not.</p>
  </header>

  <nav class="navbar">
    <ul>
      <li><a href="dashboard.php">Home</a></li>
      <li><a href="book-images.php">Books</a></li>
      <li><a href="book-renting.php">Rentals</a></li>
      <li><a href="rental_status.php" class="active">Rental Status</a></li>
      <li><a href="feedback.php">Feedbacks</a></li>
      <li><a href="welcome.php">Logout</a></li>
    </ul>
  </nav>

  <div class="container">
    <section class="rental-status">
      <h2>Your Rental Requests</h2>
      <table border="1">
        <tr>
          <!-- <th>User</th> -->
          <th>Book Title</th>
          <th>Rental Date</th>
          <th>Return Date</th>
          <th>Rent Amount</th>
          <th>Email</th>
          <th>Address</th>
          <th>Phone Number</th>
          <th>Approval Status</th>
          <th>Rental Status</th>
          <th>Fine (if overdue)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <!-- <td><?php echo htmlspecialchars($row['username']); ?></td> -->
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['rental_date']); ?></td>
            <td><?php echo htmlspecialchars($row['return_date']); ?></td>
            <td>₹<?php echo htmlspecialchars($row['rent_amount']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
            <td><?php echo ucfirst($row['approval_status']); ?></td>
            <td>
              <?php 
                $status = ucfirst($row['rental_status']); 
                echo ($status == 'Overdue') ? "<span style='color: red; font-weight: bold;'>$status</span>" : $status;
              ?>
            </td>
            <td>
              <?php 
                echo ($row['rental_status'] == 'overdue') 
                  ? "<span style='color: red;'>₹" . htmlspecialchars($row['fine_amount']) . "</span>" 
                  : "No Fine";
              ?>
            </td>
          </tr>
        <?php } ?>
      </table>
    </section>
  </div>

</body>
</html>

<?php $conn->close(); ?>
