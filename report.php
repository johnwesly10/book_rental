<?php
include("db_connection.php"); // Include database connection

// Handle date filter (default to today if no date selected)
$date = isset($_POST['rental_date']) ? $_POST['rental_date'] : date('Y-m-d');

$sql = "SELECT rentals.*, users.username, users.phone_number, books.title 
        FROM rentals 
        JOIN users ON rentals.user_id = users.user_id 
        JOIN books ON rentals.book_id = books.book_id 
        WHERE rentals.rental_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Report</title>
    <link rel="stylesheet" href="css/admin_dashboard.css"> <!-- Use admin dashboard styles -->
    <style>
        /* Style for the search form */
form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 20px 0;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Style for date input */
input[type="date"] {
    padding: 8px 12px;
    font-size: 16px;
    border: 2px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: 0.3s;
}

input[type="date"]:hover,
input[type="date"]:focus {
    border-color: #007bff;
}

/* Style for the search button */
button {
    padding: 10px 15px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <header class="header">
        <h1>Report</h1>
        <p>View and manage rental reports for a selected date.</p>
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
        <h2>Rental Report</h2>
        <form method="post">
            <label for="rental_date">Select Date:</label>
            <input type="date" name="rental_date" value="<?php echo htmlspecialchars($date); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if ($result->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Book Title</th>
                        <th>Rental Date</th>
                        <th>Return Date</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Approval Status</th>
                        <th>Rental Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo $row['rental_date']; ?></td>
                            <td><?php echo $row['return_date']; ?></td>
                            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td> <!-- Now from rentals table -->
                            <td><?php echo $row['approval_status']; ?></td>
                            <td><?php echo $row['rental_status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: red; font-weight: bold; text-align: center;">No rentals found for this date.</p>
        <?php endif; ?>
    </div>
</body>
</html>
