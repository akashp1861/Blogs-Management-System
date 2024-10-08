<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Feed</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">All Blog Posts</h1>

<?php
// Start session
session_start();

// Include the database connection
include '../partials/_dbconnect.php';

// Fetch all blogs from the database, joining with the user table to get the author's name
$sql = "SELECT blog_posts.*, contact.username FROM blog_posts 
        JOIN contact ON blog_posts.user_id = contact.sno
        ORDER BY blog_posts.created_at DESC";  // Order by most recent first
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="row">';
    while ($row = mysqli_fetch_assoc($result)) {
        $postID = $row['id'];
        $title = htmlspecialchars($row['title']);
        $content = htmlspecialchars(substr($row['content'], 0, 20000)) . '';
        $created_at = htmlspecialchars($row['created_at']);
        $author = htmlspecialchars($row['username']);
        
        echo '<div class="col-md-12 mb-4">';
        echo '<div class="card h-100">';
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
    echo '</div>';
} else {
    echo '<p>No blogs found.</p>';
}
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
