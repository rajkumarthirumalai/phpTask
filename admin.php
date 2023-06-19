<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_email'])) {
    header("Location: user_management.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the login form submission

    // Validate and sanitize the input data
    $emailid = $_POST['emailid'];
    $password = $_POST['password'];

    // Perform additional validation if needed

    // Database connection details
    include("./db_config.php");

    // Prepare and execute the SQL query to retrieve the admin details
    $selectAdminQuery = "SELECT * FROM admin WHERE emailid = ? AND password = ?";
    $stmt = $conn->prepare($selectAdminQuery);
    $stmt->bind_param("ss", $emailid, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Admin login successful, store the admin email in session and redirect to user_management.php
        $_SESSION['admin_email'] = $emailid;
        header("Location: user_management.php");
        exit();
    } else {
        // Admin login failed
        $error_message = "Invalid email address or password. Please try again.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/css/mdb.min.css" rel="stylesheet" />
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/js/mdb.min.js"></script>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <img src="./Public/log.jpg" alt="Logo" width="90" height="90">
                </div>

                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>

                <form method="post">

                    <div class="mb-3">
                        <label for="emailid" class="form-label">Email Address:</label>
                        <input type="email" class="form-control" id="emailid" name="emailid" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>

                    <p class="mt-3">Don't have an account? <a href="admin_register.php">Register here</a>.</p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
