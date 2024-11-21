<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}

$showAlert = false;
$showError = false;
include 'partials/nav.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'partials/dbconnect.php';
    
    $val = $_SESSION['sno'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $cpassword = $_POST['cpassword'];

    if ($Password == $cpassword) {
        // Hash the new password before updating
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        // Update username and password in the database
        $sql = "UPDATE user SET username = '$Username', password = '$hashedPassword' WHERE sno = '$val'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $showAlert = true;
            $_SESSION['username'] = $Username;
        } else {
            $showError = "Failed to update profile.";
        }
    } else {
        $showError = "Passwords do not match.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #333 ;
        }

        .form-container {
            margin-top: 100px;
            margin-bottom: 100px;
            padding: 25px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #556B2F;
            border: none;
        }

        .btn-primary:hover {
            background-color: #556B2F;
        }

        h2 {
            margin-bottom: 40px;
            color: #333333;

        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .message a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container mx-auto col-md-6">
        <h2 class="text-center">Update Profile</h2>

        <?php if ($showAlert): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your account has been updated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($showError): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $showError; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="/LoginSystem/update.php" method="post">
            <div class="mb-3">
                <label for="Username" class="form-label">Username</label>
                <input type="text" class="form-control" name="Username" value="<?php echo $_SESSION['username']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input type="password" class="form-control" name="Password"  required>
            </div>

            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="cpassword" required>
                <div class="form-text">Make sure to type the same password.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update</button>
            <p class="message text-center">Go to your <a href="/LoginSystem/login.php">Login</a> page</p>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
