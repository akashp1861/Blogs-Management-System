<?php
session_start();

// Include the database connection
include '../partials/dbconnect.php';

// Check if a blog ID is provided
if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    // Fetch blog details to ensure the user is authorized to delete
    $sql = "SELECT * FROM blog_posts WHERE id = $postID";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $blog = mysqli_fetch_assoc($result);

        // Check if the logged-in user is authorized to delete (admin or post owner)
        if ($_SESSION['role'] == 'admin' || $_SESSION['sno'] == $blog['user_id']) {
            // Delete the blog post
            $deleteSQL = "DELETE FROM blog_posts WHERE id = $postID";
            if (mysqli_query($con, $deleteSQL)) {
                // Redirect based on the user role
                if ($_SESSION['role'] == 'admin') {
                    header('Location: view-users.php');  // Redirect admin
                    exit;
                } elseif ($_SESSION['role'] == 'user') {
                    header('Location: view-blog-by-user.php');  // Redirect user
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
