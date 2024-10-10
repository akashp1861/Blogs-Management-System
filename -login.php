    <?php
    $login = false;
    $showError = false;
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        include 'partials/-dbconnect.php';
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
    
        // Validate inputs before querying the database
        if (!empty($Username) && !empty($Password)) {
            $sql = "SELECT * FROM user WHERE username = '$Username'";
            $result = mysqli_query($con, $sql);
            
            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password']; // Get hashed password from the database
    
                // Verify the password using password_verify()
                if (password_verify($Password, $hashedPassword)) {
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['sno'] = $row['sno'];
                    $_SESSION['username'] = $Username;
                    $_SESSION['role'] = $row['role'];
    
                    $login = true;
                    // Redirect based on role
                    if ($row['role'] == 'admin') {
                        header("location: -admin-dashboard.php");
                    } else {
                        header("location: -user-dashboard.php");
                    }
                } else {
                    $showError = "Invalid Username or Password";
                }
            } else {
                $showError = "Invalid Username or Password";
            }
        } else {
            $showError = "Please fill in both fields.";
        }
    }
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            body {
                background-color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                font-family: 'Arial', sans-serif;
            }
            
            .login-container {
                background-color: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
            }

            .login-container h1 {
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

    <div class="login-container">
        <h1>Login</h1>

        <!-- Display error/success message if applicable -->
        <?php if ($showError): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong></strong> <?php echo $showError; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($login): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> You are logged in.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="/LoginSystem/-login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="Username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="Password" required>
                <div class="form-text">Make sure to type the correct password.</div>
            </div>
            <button type="submit" class="btn btn-custom w-100">Login</button>
            <p class="message">Not registered? <a href="/LoginSystem/-signup.php">Create an account</a></p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
