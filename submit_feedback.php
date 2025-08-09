<?php
session_start(); // Start the session
include("db_connection.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to submit feedback.'); window.location.href='login.php';</script>";
    exit();
}

// Get logged-in user's details from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize additional form data
    $mobile = isset($_POST['mobile']) ? $conn->real_escape_string($_POST['mobile']) : null;
    $rating = $conn->real_escape_string($_POST['rating']);
    $message = $conn->real_escape_string($_POST['message']);
    $date = date('Y-m-d H:i:s'); // Current date and time

    // SQL query to insert data into the feedback table
    $sql = "INSERT INTO feedback (user_id, username, email, mobile, rating, message, date) 
            VALUES ('$user_id', '$username', '$email', '$mobile', '$rating', '$message', '$date')";

    // Execute query and check result
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href='feedback.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
