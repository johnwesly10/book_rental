<?php
include("db_connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Rental Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
  <div class="dashboard">
    <header class="header">
      <h1>Book Rental Dashboard</h1>
      <p>Welcome to the Book Rental System</p>
    </header>

    <nav class="navbar">
      <ul>
        <li><a href="dashboard.php" class="active">Home</a></li>
        <li><a href="book-images.php">Books</a></li>
        <li><a href="rental_status.php">Rental Status</a></li>
        <li><a href="feedback.php">Feedbacks</a></li>
        <li><a href="welcome.php">Logout</a></li>
      </ul>
    </nav>

    <section class="background-section">
      <img src="images/back.jpg" alt="">
      <div class="overlay-text">
        <h2>Rent Books</h2>
        <p>Explore a wide range of books for rent at affordable prices.
             Enjoy reading without the need to buy, and return books hassle-free. 
             Discover new stories, expand your knowledge by borrowing books anytime!</p>
      </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="new-arrivals">
      <h2>New Arrivals</h2>
      <div class="book-container">
        <?php
          $sql = "SELECT key_slug, title, image FROM books ORDER BY book_id DESC LIMIT 4";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="book">';
              echo '<a href="book-info.php?book=' . htmlspecialchars($row['key_slug']) . '">';
              echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
              echo '</a>';
              echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
              echo '</div>';
            }
          } else {
            echo '<p>No new arrivals at the moment.</p>';
          }
        ?>
      </div>
    </section>

    <!-- Best Sellers Section -->
    <section class="best-sellers">
      <h2>Best Sellers</h2>
      <div class="book-container">
        <?php
          $sql = "SELECT books.key_slug, books.title, books.image, COUNT(rentals.book_id) AS rent_count 
                  FROM books 
                  JOIN rentals ON books.book_id = rentals.book_id 
                  GROUP BY rentals.book_id 
                  ORDER BY rent_count DESC 
                  LIMIT 4";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="book">';
              echo '<a href="book-info.php?book=' . htmlspecialchars($row['key_slug']) . '">';
              echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
              echo '</a>';
              echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
              // echo '<p>Rented ' . $row['rent_count'] . ' times</p>';
              echo '</div>';
            }
          } else {
            echo '<p>No best sellers yet.</p>';
          }
          $conn->close();
        ?>
      </div>
    </section>

    <section class="about-us">
  <h2>About Us</h2>
  <div class="about-container">
    <div class="about-img">
      <img src="images/aboutus1.jpg" alt="About Us">
    </div>
    <div class="about-content">
      <p>
        Welcome to our platform! We are dedicated to providing the best experience
        for our users with top-quality content and services. Our goal is to deliver
        engaging and valuable information that makes a difference.<br><br>
        <b>Our Mission</b><br><br>
        At our book shop, we believe that knowledge and entertainment should be available 
        to all. Our mission is to provide a seamless and budget-friendly way for readers to 
        explore a vast collection of books across different genres, including fiction, non-fiction,
        academic, self-help, and more.
      </p>
    </div>
  </div>
</section>


    <h2>Contact Us</h2>
    <section class="contact-us">
      <div class="contact-container">
        <div class="contact-box email-box">
          <p><strong>Email:</strong> support@bookrental.com</p>
        </div>
        <div class="contact-box phone-box">
          <p><strong>Phone:</strong> +123 456 7890</p>
        </div>
        <div class="contact-box address-box">
          <p><strong>Address:</strong> 123 Library Street, Booktown, BK 56789</p>
        </div>
      </div>
    </section>
  </div>
</body>
</html>
