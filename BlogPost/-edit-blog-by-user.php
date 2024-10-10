<?php
// Start session
session_start();

require '../partials/-nav.php';
// Include the database connection
include '../partials/-dbconnect.php';


// Check if a blog ID is provided
if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    // Fetch blog details
    $sql = "SELECT * FROM blog_posts WHERE id = $postID";
    $result = mysqli_query($con, $sql);

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
} else {
    echo 'No blog post ID provided.';
    exit;
}

// Handle form submission for editing the blog post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $content = mysqli_real_escape_string($con, $_POST['content']);

    $updateSQL = "UPDATE blog_posts SET title = '$title', content = '$content' WHERE id = $postID";
    if (mysqli_query($con, $updateSQL)) {
        header('Location:-view-blog-by-user.php');
        exit;
    } else {
        echo 'Error updating the blog post.';
    }
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
            <form action="-edit-blog-by-user.php?id=<?php echo $postID;?>" method="POST">
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

                <button type="submit" class="btn btn-custom w-100">Edit Post</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>