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
    $deleteBlogsSQL = "DELETE FROM blog_posts WHERE user_id = ?";
    $stmtBlogs = mysqli_prepare($con, $deleteBlogsSQL); // Prepare the statement
    mysqli_stmt_bind_param($stmtBlogs, 'i', $userID); // Bind the user ID as an integer
    $deleteBlogsResult = mysqli_stmt_execute($stmtBlogs); // Execute the statement

    if ($deleteBlogsResult) {
        // After deleting the blogs, delete the user
        $deleteUserSQL = "DELETE FROM user WHERE sno = ?";
        $stmtUser = mysqli_prepare($con, $deleteUserSQL); // Prepare the statement
        mysqli_stmt_bind_param($stmtUser, 'i', $userID); // Bind the user ID as an integer
        $deleteUserResult = mysqli_stmt_execute($stmtUser); // Execute the statement

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

    // Close the prepared statements
    mysqli_stmt_close($stmtBlogs);
    mysqli_stmt_close($stmtUser);

} else {
    // No user ID provided
    echo "No user ID provided.";
}
?>
