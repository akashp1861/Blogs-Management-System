<?php
// Start session
session_start();

// Check if the user is logged in and has admin role
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Include database connection
include '../partials/dbconnect.php';

// Fetch all users from the database using prepared statements
$sql = "SELECT sno, username, role FROM user";
$stmt = $con->prepare($sql); // Prepare the statement

if ($stmt) {
    $stmt->execute(); // Execute the statement
    $result = $stmt->get_result(); // Get the result set
} else {
    die("Error preparing statement: " . $con->error);
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <title>Manage Users</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #333; /* Dark gray background */
        }

        h3.mt-4 {
            color: white;
            padding : 10px;
        }

        /* Table styles */
        .table {
            background-color: white; /* White background for the table */
            border-radius: 10px; /* Rounded corners */
            overflow: hidden; /* Prevents overflow from rounded corners */
        }

        .table thead th {
            background-color: #556B2F; /* Dark green for the header */
            color: white; /* White text */
        }

        .table tbody tr {
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .table tbody tr:hover {
            background-color: #f2f2f2; /* Light gray on hover */
        }

        .btn-primary {
            background-color: #556B2F; /* Bootstrap primary color */
           
        }
        .btn-primary:hover {
            background-color: #556B2F; /* Light orange on hover */
            
        }

        .btn-danger {
             background-color: #556B2F; /* Dark orange */
             color: white;
        }

        .btn-danger:hover {
              background-color: #556B2F; /* Lighter orange on hover */
              border-color: #FF6347;
        }

        .btn-info {
              background-color: #556B2F; /* Your custom background color */
              color: white; /* Text color */
        }

       .btn-info:hover {     
           background-color: #556B2F; /* Ensure the background color stays the same on hover */
           color: white; /* Text color stays the same */
        }
    </style>
</head>
<body>
    <?php include '../partials/nav.php'; ?>
    
    <div class="container">
        <h3 class="mt-4">Manage Users</h3>
        
        <?php
        if (isset($_GET['message'])) {
            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['message']) . '</div>';
        }
        ?>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['sno']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['role']) . '</td>';
                    echo '<td>';
                    echo '<a href="edit-user-role.php?sno=' . htmlspecialchars($row['sno']) . '" class="btn btn-primary btn-sm">Edit</a> ';
                    echo '<a href="delete-user.php?sno=' . $row['sno'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this user and all their blogs?\')">Delete</a>';
                    echo ' ';
                    echo '<a href="manageuser-blog-by-admin.php?sno=' . $row['sno'] . '" class="btn btn-info btn-sm">Blogs</a>';  // Add Blogs button here
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the statement and database connection
$stmt->close();
$con->close();
?>








