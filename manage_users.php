<?php
include("db_connection.php");

// Handle user deletion (Prevent deletion of admins)
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Check if user is admin before deleting
    $stmt = $conn->prepare("SELECT role FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['role'] !== 'admin') {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        header("Location: manage_users.php?msg=deleted");
        exit();
    } else {
        header("Location: manage_users.php?msg=error");
        exit();
    }
}

// Handle user update (Role & Phone Number)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $user_id = intval($_POST['user_id']);
    $new_role = $_POST['role'];
    $new_phone = $_POST['phone_number'];

    $stmt = $conn->prepare("UPDATE users SET role = ?, phone_number = ? WHERE user_id = ?");
    $stmt->bind_param("sii", $new_role, $new_phone, $user_id);
    $stmt->execute();
    header("Location: manage_users.php?msg=updated");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT user_id, username, email, role, phone_number FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <header class="header">
        <h1>Manage Users</h1>
        <p>View, edit, and manage user accounts efficiently from this panel.</p>
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
        <h2>User List</h2>
        
        <?php if (isset($_GET['msg'])): ?>
            <p class="msg">
                <?php 
                    if ($_GET['msg'] == 'deleted') echo "User deleted successfully!";
                    elseif ($_GET['msg'] == 'updated') echo "User updated successfully!";
                    else echo "Admin users cannot be deleted!";
                ?>
            </p>
        <?php endif; ?>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                <select name="role">
                                    <option value="user" <?php echo $row['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                                    <option value="admin" <?php echo $row['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                        </td>
                        <td>
                            <input type="number" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>">
                        </td>
                        <td>
                            <button type="submit" name="update_user">Update</button>
                            </form>
                            <?php if ($row['role'] !== 'admin'): ?>
                                <a href="manage_users.php?delete_id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            <?php else: ?>
                                <span style="color: gray;">Not Allowed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
