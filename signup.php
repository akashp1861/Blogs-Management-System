<?php
$showError = false;
$showSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include 'partials/_dbconnect.php';
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $cPassword = $_POST['cPassword'];

    // Check if the username already exists
    $existSQL = "SELECT * FROM contact WHERE username = '$Username'";
    $result = mysqli_query($con, $existSQL);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        $showError = "Username already exists.";
    } elseif ($Password != $cPassword) {
        $showError = "Passwords do not match.";
    } else {
        // Insert the new user
        $sql = "INSERT INTO contact (username, password) VALUES ('$Username', '$Password')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $showSuccess = "Your account has been created successfully. You can now log in.";
        } else {
            $showError = "An error occurred during signup. Please try again.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #333 ;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        
        .signup-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .signup-container h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .btn-custom {
            background-color: #556B2F;
            color: white;
        }

        .btn-custom:hover {
            background-color: #556B2F;
            color: white;
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .message a {
            color: #556B2F;
            text-decoration: none;
        }

        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h1>Signup</h1>

    <!-- Display error/success message if applicable -->
    <?php if ($showError): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> <?php echo $showError; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($showSuccess): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo $showSuccess; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="/LoginSystem/signup.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="Username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="Password" required>
        </div>
        <div class="mb-3">
            <label for="cPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cPassword" name="cPassword" required>
            <div class="form-text">Make sure to enter the same password for confirmation.</div>
        </div>
        <button type="submit" class="btn btn-custom w-100">Signup</button>
        <p class="message">Already registered? <a href="/LoginSystem/login.php">Login here</a></p>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
