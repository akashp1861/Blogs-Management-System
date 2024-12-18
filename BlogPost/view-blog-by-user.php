<?php
// Start session at the very beginning of the file, before any output
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection and other necessary files
include '../partials/nav.php';
include '../partials/dbconnect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blogs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Custom styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #333; /* Dark gray background */
    }

    .container {
        margin-top: 40px;
    }

    h4 {
        color: white;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        margin-bottom: 30px;
        background-color: #556B2F; /* Dark Green */
        height: 50px;
        padding: 10px;
        width: 25%;
    }

    .notice {
        color: white;
        font-size: 20px;
    }

    .btn-warning {
        background-color: white;
        color: black;
        border-color: black;
    }

    .btn-warning:hover {
        background-color: #90EE90;
        color: black;
        border-color: #90EE90;
    }

    .btn-danger {
        background-color: #556B2F;
        border-color: green;
    }
    </style>
</head>
<body>
    <div class="container mt-4">
        <?php
        // Display username and role
        $name = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
        echo '<h4>' . $name . " Blogs:" . '</h4>';

        // Fetch user ID from session
        $loggedInUserId = isset($_SESSION['sno']) ? $_SESSION['sno'] : 0;  // Default value 0 if not set

        // Determine which blogs to display
        if ($_SESSION['role'] == 'admin' && isset($_GET['user_id'])) {
            $userID = $_GET['user_id'];  // View blogs of a specific user
        } else {
            // Non-admin users can only see their own blogs
            $userID = $loggedInUserId;
        }

        // Prepare the SQL query using a prepared statement
        $sql = "SELECT blog_posts.*, user.username FROM blog_posts 
                JOIN user ON blog_posts.user_id = user.sno 
                WHERE blog_posts.user_id = ?";
        $stmt = $con->prepare($sql);

        // Bind the parameter
        $stmt->bind_param("i", $userID); // "i" indicates integer type

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                $postID = $row['id'];
                $title = htmlspecialchars($row['title']);
                $content = htmlspecialchars($row['content']); // Show full content
                $created_at = htmlspecialchars($row['created_at']);
                $author = htmlspecialchars($row['username']);

                // Display each blog post
                echo '<div class="col-md-12">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h3 class="card-title">' . $title . '</h3>';
                echo '<p class="card-text">' . nl2br($content) . '</p>';
                echo '</div>';
                echo '<div class="card-footer text-muted">';
                echo 'Posted on ' . $created_at . ' by ' . $author;

                // Display edit and delete buttons for admin or the owner of the blog post
                if ($_SESSION['role'] == 'admin' || $_SESSION['sno'] == $row['user_id']) {
                    echo '<div class="mt-2">';
                    echo '<a href="edit-blog-by-user.php?id=' . $postID . '" class="btn btn-warning btn-sm">Edit</a>';
                    echo ' <a href="delete-blog.php?id=' . $postID . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this blog post?\');">Delete</a>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "<p class = 'notice'> No blogs found !!.</p>";
        }

        // Close the statement
        $stmt->close();
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
