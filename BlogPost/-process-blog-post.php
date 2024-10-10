<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: -login.php");
    exit;
}

// Include the database connection
include '../partials/-dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    // Get form inputs
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Get the author from session (username of the logged-in user)
    $author = $_SESSION['username'];
    $user_id = $_SESSION['sno'];  // Assuming user ID is stored in session

    // Sanitize inputs
    $title = mysqli_real_escape_string($con, $title);
    $content = mysqli_real_escape_string($con, $content);
    $author = mysqli_real_escape_string($con, $author);
    
    // Prepare SQL query
    $sql = "INSERT INTO `blogsmanagement`.`blog_posts` (title, content, author, user_id, created_at) 
            VALUES ('$title', '$content', '$author', $user_id, NOW())";

    // Execute SQL query
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Success: Redirect to confirmation page
        header("Location: -view-blog.php");  // Adjust this as needed
    } else {
        // Error: Redirect with error message
        header("Location: admin_dashboard.php?post_error=true");
    }
}

// Close the database connection
mysqli_close($con);
?>
