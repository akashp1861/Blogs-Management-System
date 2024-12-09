<?php
session_start();

// Include the database connection
include '../partials/dbconnect.php';

// Check if a blog ID is provided
if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    // Prepare the SQL statement to fetch blog details
    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql); // Prepare the statement
    mysqli_stmt_bind_param($stmt, 'i', $postID); // Bind the parameter
    mysqli_stmt_execute($stmt); // Execute the statement
    $result = mysqli_stmt_get_result($stmt); // Get the result set

    if (mysqli_num_rows($result) == 1) {
        $blog = mysqli_fetch_assoc($result);

        // Check if the logged-in user is authorized to delete (admin or post owner)
        if ($_SESSION['role'] == 'admin' || $_SESSION['sno'] == $blog['user_id']) {
            // Prepare the SQL statement to delete the blog post
            $deleteSQL = "DELETE FROM blog_posts WHERE id = ?";
            $deleteStmt = mysqli_prepare($con, $deleteSQL); // Prepare the statement
            mysqli_stmt_bind_param($deleteStmt, 'i', $postID); // Bind the parameter
            if (mysqli_stmt_execute($deleteStmt)) { // Execute the statement
                // Redirect based on the user role
                if ($_SESSION['role'] == 'admin') {
                    header('Location: view-users.php'); // Redirect admin
                    exit;
                } elseif ($_SESSION['role'] == 'user') {
                    header('Location: view-blog-by-user.php'); // Redirect user
                    exit;
                }
            } else {
                echo 'Error deleting the blog post.';
            }
        } else {
            echo 'You are not authorized to delete this blog post.';
        }
    } else {
        echo 'Blog post not found.';
    }
} else {
    echo 'No blog post ID provided.';
}
?>
