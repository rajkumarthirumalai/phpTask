<?php
session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_email'])) {
    header("Location: dashboard.php");
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
        header("Location: dashboard.php");
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
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/css/mdb.min.css" rel="stylesheet" />
    <style>
        body {
            /* fallback for old browsers */
            background: #a1c4fd;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/js/mdb.min.js"></script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="text-center mb-4" style="text-align:center">
                    <img src="./Public/log.jpg" alt="Logo" width="90" height="90"
                        style="border-radius:25px; margin-bottom:10px">
                </div>

                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="row">

                        <div class=" mb-3">
                            <label for="emailid" class="form-label">Email Address:</label>
                            <input type="email" class="form-control" id="emailid" name="emailid" required>
                        </div>

                        <div class=" mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>

                    <button type="submit" type="submit" class=" btn btn-dark btn-lg"
                        data-mdb-ripple-color="dark">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
