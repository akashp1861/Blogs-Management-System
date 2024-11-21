
<?php
session_start(); // Start session to access session variables
include '../partials/nav.php';
// Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php"); // Redirect to login if not logged in
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog Post</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

body {
            font-family: 'Arial', sans-serif;
            background-color: #333;
        }

        .form-container {
            margin: 50px auto;
            max-width: 600px;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 26px;
            text-align: center;
            color: #333;
        }

        .btn-custom {
            background-color: #556B2F;
            color: white;
        }

        .btn-custom:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Create a Blog Post</h1>
            <form action="process-blog-post.php" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Blog Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label" >Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?php echo $_SESSION['username']; ?>" readonly >
                </div>

                <button type="submit" class="btn btn-custom w-100">Create Blog</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
