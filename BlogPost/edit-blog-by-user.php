<?php
// Start session
session_start();

include '../partials/nav.php';
// Include the database connection
include '../partials/dbconnect.php';

// Check if a blog ID is provided
if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    // Fetch blog details using a prepared statement
    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $postID); // Bind $postID as an integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $blog = mysqli_fetch_assoc($result);

        // Check if the logged-in user is authorized to edit (admin or post owner)
        if ($_SESSION['role'] != 'admin' && $_SESSION['sno'] != $blog['user_id']) {
            echo 'Unauthorized access.';
            exit;
        }
    } else {
        echo 'Blog post not found.';
        exit;
    }
    mysqli_stmt_close($stmt); // Close the prepared statement
} else {
    echo 'No blog post ID provided.';
    exit;
}

// Handle form submission for editing the blog post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the blog using a prepared statement
    $updateSQL = "UPDATE blog_posts SET title = ?, content = ? WHERE id = ?";
    $stmtUpdate = mysqli_prepare($con, $updateSQL);
    mysqli_stmt_bind_param($stmtUpdate, 'ssi', $title, $content, $postID); // Bind title (string), content (string), and postID (integer)
    $updateResult = mysqli_stmt_execute($stmtUpdate);

    if ($updateResult) {
        header('Location: view-blog-by-user.php');
        exit;
    } else {
        echo 'Error updating the blog post.';
    }
    mysqli_stmt_close($stmtUpdate); // Close the prepared statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        body{
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
            background-color: #556B2F;
        }
    </style>
</head>
<body>

<div class="container">
        <div class="form-container">
            <h1>Edit Blog Post</h1>
            <form action="edit-blog-by-user.php?id=<?php echo $postID;?>" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Blog Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']);?>" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="8" required><?php echo htmlspecialchars($blog['content']); ?></textarea>

                <div class="mb-3">
                    <label for="author" class="form-label" >Author</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?php echo $_SESSION['username']; ?>" readonly >
                </div>

                <button type="submit" class="btn btn-custom w-100">Edit blog</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>