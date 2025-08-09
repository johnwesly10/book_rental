<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to rent a book.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$book_slug = $_GET['book_id'] ?? '';

// Redirect if no book_id is provided
if (empty($book_slug)) {
    echo "<script>alert('Invalid book selection!'); window.location.href = 'book-images.php';</script>";
    exit();
}

// Fetch book details using `key_slug`, but also get `book_id`
$title = "";
$rent_amount = "";
$book_id = null;

$stmt = $conn->prepare("SELECT book_id, title, rent_amount FROM books WHERE key_slug = ?");
$stmt->bind_param("s", $book_slug);
$stmt->execute();
$book_result = $stmt->get_result();

if ($book_result->num_rows > 0) {
    $book = $book_result->fetch_assoc();
    $book_id = $book['book_id'];
    $title = $book['title'];
    $rent_amount = $book['rent_amount'];
} else {
    echo "<script>alert('Book not found!'); window.location.href = 'book-images.php';</script>";
    exit();
}
$stmt->close();

// Fetch user details
$username = "";
$email = "";
$phone_number = "";
$user_stmt = $conn->prepare("SELECT username, email, phone_number FROM users WHERE user_id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $username = $user['username'];
    $email = $user['email'];
    $phone_number = $user['phone_number'];
}
$user_stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rent_submit'])) {
    $address = $conn->real_escape_string($_POST['address']);
    $rental_date = date("Y-m-d");
    $return_date = date("Y-m-d", strtotime("+7 days"));

    // Ensure `book_id` exists before inserting
    if ($book_id !== null) {
        $insert_sql = "INSERT INTO rentals (user_id, book_id, rental_date, return_date, address, approval_status, rental_status) 
                       VALUES (?, ?, ?, ?, ?, 'pending', 'pending')";
        
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iisss", $user_id, $book_id, $rental_date, $return_date, $address);

        if ($stmt->execute()) {
            $rental_id = $stmt->insert_id;
            $_SESSION['rental_success'] = [
                'rental_id' => $rental_id,
                'book_id' => $book_id
            ];
            header("Location: book_renting_success.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Book ID not found!'); window.location.href = 'book-images.php';</script>";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Book</title>
    <link rel="stylesheet" href="css/book-renting.css">
</head>
<body>

<header>
    <h1>Rent a Book</h1>
</header>


<div class="container">
    <section class="rent-book-form">
        <h2>Rent a Book</h2>
        <form method="POST" >
            <div class="form-group">
                <label for="book_title">Book Title:</label>
                <input type="text" name="book_title" id="book_title" value="<?php echo htmlspecialchars($title); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="rent_amount">Rent Amount:</label>
                <input type="text" name="rent_amount" id="rent_amount" value="₹<?php echo htmlspecialchars($rent_amount); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="address">Delivery Address:</label>
                <input type="text" name="address" id="address" required placeholder="Enter your delivery address">
            </div>

            <button type="submit" name="rent_submit">Confirm Rental</button>
        </form>
    </section>
</div>

</body>
</html>
