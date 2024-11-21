<?php 
// Start session
session_start();
include '../partials/nav.php'; // Navbar file
include '../partials/dbconnect.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Feed</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles to make the page more attractive */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #333;
        }

        .container {
            margin-top: 40px;
        }

        h2.text-center {
            font-weight: 600;
            margin-bottom: 30px;
            background-color: #556B2F;
            color: white;
            height: 50px;
            
            
        }

        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease-in-out;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 24px;
            color: #333;
        }
          
        .card-text {
            color: #555;
            font-size: 16px;
        }

        .card-footer {
            background-color: #f1f1f1;
            font-size: 14px;
            color: #888;
        }

        .no-blogs-message {
            text-align: center;
            font-size: 20px;
            color: white;
        }

        /* Adjust card body to expand as needed */
        .card-body {
            min-height: auto; /* Allow card height to expand based on content */
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Container to hold the blog post content -->
    <div class="container">
        <h2 class="text-center"> Blogs Feed</h2>

        <?php
        // Fetch all blogs from the database, joining with the user table to get the author's name
        $sql = "SELECT blog_posts.*, user.username FROM blog_posts 
                JOIN user ON blog_posts.user_id = user.sno
                ORDER BY blog_posts.created_at DESC";  // Order by most recent first
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Displaying posts one by one (full width)
            while ($row = mysqli_fetch_assoc($result)) {
                $postID = $row['id'];
                $title = htmlspecialchars($row['title']);
                $content = htmlspecialchars($row['content']); // Show full content now without truncating
                $created_at = htmlspecialchars($row['created_at']);
                $author = htmlspecialchars($row['username']);
                
                // Display each blog post in a full-width Bootstrap card
                echo '<div class="col-md-12">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h3 class="card-title">' . $title . '</h3>';
                echo '<p class="card-text">' . nl2br($content) . '</p>';
                echo '</div>';
                echo '<div class="card-footer text-muted">';
                echo 'Posted on ' . $created_at . ' by ' . $author;
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // If no blogs found
            echo '<p class="no-blogs-message">No blogs found.</p>';
        }
        ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
