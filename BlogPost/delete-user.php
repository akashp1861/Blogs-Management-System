<?php
// Start session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Include the database connection
include '../partials/dbconnect.php';

// Check if the user ID is provided in the URL
if (isset($_GET['sno'])) {
    $userID = $_GET['sno'];

    // First, delete all the blogs associated with the user
    $deleteBlogsSQL = "DELETE FROM blog_posts WHERE user_id = $userID";
    $deleteBlogsResult = mysqli_query($con, $deleteBlogsSQL);

    if ($deleteBlogsResult) {
        // After deleting the blogs, delete the user
        $deleteUserSQL = "DELETE FROM user WHERE sno = $userID";
        $deleteUserResult = mysqli_query($con, $deleteUserSQL);

        if ($deleteUserResult) {
            // User and their blogs deleted successfully, redirect to the manage users page
            header("Location: view-users.php");
            exit;
        } else {
            echo "Error deleting user.";
        }
    } else {
        echo "Error deleting user's blogs.";
    }
} else {
    // No user ID provided
    echo "No user ID provided.";
}
?>
