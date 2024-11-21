<?php

session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #333;
        }

        .dashboard-container {
            margin-top: 100px;
            padding: 50px;
            background-color: #ffffff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        .btn-logout {
            margin-top: 30px;
            background-color: #556B2F;
        }

        h1 {
            color: #333333;
        }

        p {
            color: #666666;
        }

        .quote {
            font-style: italic;
            color: #4CAF50;
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php  include 'partials/nav.php';?>
<div class="container">

    <div class="dashboard-container mx-auto col-md-8">
        <h1>Welcome, <?php echo ucfirst($username); ?>!</h1>
        <p>You are logged in as an Admin.</p>

        <div class="quote">
            "Blogging connects your voice to the world"
        </div>

        <a href= "BlogPost/blog-post-feed.php" class="btn btn-danger btn-logout">All Blogs Posts</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
