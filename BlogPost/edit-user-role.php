<?php
// Start session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Include the database connection
include '../partials/dbconnect.php';

// Check if the user ID is provided in the URL
if (isset($_GET['sno'])) {
    $userID = $_GET['sno'];

    // Fetch user details using a prepared statement
    $sql = "SELECT * FROM user WHERE sno = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $userID); // Bind $userID as an integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        // Fetch the user data
        $user = mysqli_fetch_assoc($result);
    } else {
        // User not found
        echo "User not found.";
        exit;
    }
    mysqli_stmt_close($stmt); // Close the prepared statement
} else {
    // If no user ID is provided in the URL
    echo "No user ID provided.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update user details in the database using a prepared statement
    $updateSQL = "UPDATE user SET username = ?, role = ? WHERE sno = ?";
    $stmtUpdate = mysqli_prepare($con, $updateSQL);
    mysqli_stmt_bind_param($stmtUpdate, 'ssi', $username, $role, $userID); // Bind username (string), role (string), and userID (integer)
    $updateResult = mysqli_stmt_execute($stmtUpdate);

    if ($updateResult) {
        // Successfully updated
        header("Location: view-users.php");
        exit;
    } else {
        echo "Error updating user.";
    }
    mysqli_stmt_close($stmtUpdate); // Close the prepared statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
        font-family: 'Arial', sans-serif;
        background-color: #333; /* Dark gray background */
    }
        .container {
            margin-top: 150px;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }

        .form-label {
            color: #333;
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            
        }

        .btn-primary {
            background-color: #556B2F;
            border-color: #007bff;
            width: 100%;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #556B2F;
            border-color: #0056b3;
        }

        .form-select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include '../partials/nav.php'?>
<div class="container">
    <h2>Edit User</h2>

    <!-- Form to edit user -->
    <form method="POST" action="edit-user-role.php?sno=<?php echo $userID; ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control form-select" id="role" name="role" required>
                <option class="selected" value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>

</div>

</body>
</html>
