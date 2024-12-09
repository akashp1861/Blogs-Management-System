<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection
include '../partials/dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Get the author from session (username of the logged-in user)
    $author = $_SESSION['username'];
    $user_id = $_SESSION['sno'];  // Assuming user ID is stored in session

    // Prepare the SQL query using a prepared statement
    $sql = "INSERT INTO `blogsmanagement`.`blog_posts` (title, content, author, user_id, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($con, $sql);
    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $author, $user_id);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Success: Redirect to confirmation page
        header("Location: view-blog.php");  // Adjust this as needed
    } else {
        // Error: Redirect with error message
        header("Location: admin-dashboard.php?post_error=true");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($con);
?>
