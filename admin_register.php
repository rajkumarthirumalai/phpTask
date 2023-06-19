<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_email'])) {
    header("Location: user_management.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the registration form submission

    // Validate and sanitize the input data
    $username = $_POST['username'];
    $emailid = $_POST['emailid'];
    $password = $_POST['password'];
    $role_id = 1; // Default role_id for admin

    // Perform additional validation if needed

    // Database connection details
    include("./db_config.php");

    // Prepare and execute the SQL query to insert the new admin into the "admin" table
    $insertAdminQuery = "INSERT INTO admin (username, emailid, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertAdminQuery);
    $stmt->bind_param("sssi", $username, $emailid, $password, $role_id);

    if ($stmt->execute()) {
        // Registration successful, redirect to the admin login page
        header("Location: admin_login.php");
        exit();
    } else {
        // Registration failed
        $error_message = "Registration failed. Please try again.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/css/mdb.min.css" rel="stylesheet" />
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/js/mdb.min.js"></script>
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Admin Registration</h2>

        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="emailid" class="form-label">Email ID:</label>
                <input type="email" class="form-control" id="emailid" name="emailid" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <p>Already have an account? <a href="admin_login.php">Login here</a>.</p>
        </form>
    </div>

</body>
</html>
