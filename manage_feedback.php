<?php
include("db_connection.php");

// Handle feedback deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM feedback WHERE id = $delete_id");
    header("Location: manage_feedback.php");
    exit();
}

// Fetch all feedback entries
$result = $conn->query("SELECT * FROM feedback ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <style>
        /* Button Styles */
        .reply-btn, .delete-btn {
            display: inline-block;
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            margin: 2px;
        }

        .reply-btn {
            background-color: #28a745; /* Green */
        }

        .delete-btn {
            background-color: #dc3545; /* Red */
        }

        .reply-btn:hover {
            background-color: #218838;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Manage Feedback</h1>
        <p>Review and respond to user feedback to enhance their experience.</p>
    </header>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">Dashboard</a>
        <div class="menu-item">
            <a href="#">Manage Books</a>
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
        <div class="dashboard-content">
            <h2>User Feedback</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Rating</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                            <td><?php echo $row['rating']; ?>/5</td>
                            <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td>
                                <!-- Reply Button (Redirects to Gmail) -->
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($row['email']); ?>" 
                                   target="_blank" 
                                   class="reply-btn">Reply</a>

                                <!-- Delete Button -->
                                <a href="manage_feedback.php?delete_id=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this feedback?');" 
                                   class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
