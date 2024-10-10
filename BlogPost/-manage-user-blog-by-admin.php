<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blogs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

    body{
        background-color: #333;
    }


    .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    margin-bottom: 20px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

    h3.my-4{
        color: white;
    }  

    .btn-primary{
        background-color: #90EE90;
        color: black;  
        border-color : black;  
    }
    .btn-primary:hover{
        background-color: #556B2F;
        color: white;   
        border-color : black;  

    }

    .btn-warning{
        background-color: white;
        color: black;
        border-color :black;

    }
    .btn-warning:hover{
        background-color: #90EE90;
        color: black;
        border-color : #90EE90;

    }

    .btn-danger{
        background-color: #556B2F;
        border-color : green;

    }

    .notice{
        color: white;
        font-size: 30px;
    }
    </style>
</head>
<body>
    <div class="container mt-4">   

<?php
// Start session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['loggedin'])) {
    header("Location: -login.php");
    exit;
}

// Include the database connection
include '../partials/-dbconnect.php';

// Check if the user ID is provided in the URL
if (isset($_GET['sno'])) {
    $userID = $_GET['sno'];

    // Fetch the author's name
    $authorQuery = "SELECT username FROM user WHERE sno = $userID";
    $authorResult = mysqli_query($con, $authorQuery);

    if ($authorResult && mysqli_num_rows($authorResult) == 1) {
        $authorRow = mysqli_fetch_assoc($authorResult);
        $authorName = htmlspecialchars($authorRow['username']);

        // Fetch all blogs associated with this user
        $sql = "SELECT * FROM blog_posts WHERE user_id = $userID";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="container">';
            echo '<h3 class="my-4">Blogs by Author: ' . $authorName . '</h3>';
            echo '<a href="-view-users.php" class="btn btn-primary mb-4">Back to Users</a>';
            
            // Start a row
            echo '<div class="row">';

            while ($row = mysqli_fetch_assoc($result)) {
                $blogID = $row['id'];  // Assuming the blog_posts table has an "id" field
                $title = htmlspecialchars($row['title']);
                $content = htmlspecialchars(substr($row['content'], 0, 20000));  // Truncate content to 200 chars

                // Display each blog in a card
                echo '<div class="col-md-12 mb-4">';  // Adjust to "col-md-6" for a vertical layout
                echo '<div class="card h-100">';  // Full height card for even spacing
                echo '<div class="card-body">';
                echo '<h4 class="card-title">' . $title . '</h4>';
                echo '<p class="card-text">' . nl2br($content) . '...</p>';
                echo '</div>';
                echo '<div class="card-footer text-muted">';
                echo 'Posted on ' . htmlspecialchars($row['created_at']) . ' by ' . $authorName;
                
                // Add Edit and Delete buttons
                echo '<div class="mt-3">';
                echo '<a href="-edit-blog-by-admin.php?id=' . $blogID . '" class="btn btn-warning me-2">Edit</a>';
                echo '<a href="-delete-blog.php?id=' . $blogID . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this blog?\')">Delete</a>';
                echo '</div>';
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            // Close the row
            echo '</div>';
            echo '</div>';
        } else {
            echo '<a href="get_user.php" class="btn btn-primary mb-4">Back to Users</a>';
            echo "<p class ='notice'> No blogs found for $authorName!!.</p>";
        }
    } else {
        // Author not found
        echo '<p>Author not found.</p>';
    }
} else {
    // No user ID provided
    echo "No user ID provided.";
}
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
