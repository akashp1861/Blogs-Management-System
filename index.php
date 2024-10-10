<?php
session_start();

// Include database connection
include 'partials/-dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: /LoginSystem/-login.php");
    exit();
}

// Default content
$page = isset($_GET['page']) ? $_GET['page'] : 'login'; // Default to 'login'

// Routing logic
switch ($page) {
    case 'update':
        include '-update.php'; // Update profile page
        break;
    case 'login':
        include '-login.php'; // Login page
        break;
    case 'signup':
        include '-signup.php'; // Signup page
        break;
    default:
        include '-login.php'; // Default home page
        break;
}
?>
