

<?php
session_start();

// Destroy the session and unset all session variables
session_unset();
session_destroy();

// Redirect to login page after logging out
header("Location: login.php");
exit();
?>
