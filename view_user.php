<?php
session_start();

// Check if the user ID is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Database connection details
    include("./db_config.php");

    // Prepare and execute the SQL query to retrieve the user details
    $selectUserQuery = "SELECT u.*, r.role FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?";
    $stmt = $conn->prepare($selectUserQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given ID exists
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $emailid = $row['emailid'];
        $phone_number = $row['phone_number'];
        $date_of_birth = $row['date_of_birth'];
        $address = $row['address'];
        $account_number = $row['account_number'];
        $capital_amount = $row['capital_amount'];
        $status = $row['status'];
        $role = $row['role'];
    } else {
        // If the user doesn't exist, redirect back to the user management page
        header("Location: dashboard.php");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    // If the user ID is not provided, redirect back to the user management page
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/css/mdb.min.css" rel="stylesheet" />
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/js/mdb.min.js"></script>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2>User Details</h2>

                <div class="mb-3">
                    <label class="form-label"><b>First Name:</b> <?php echo $firstname; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Last Name:</b> <?php echo $lastname; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Email:</b> <?php echo $emailid; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Phone Number:</b> <?php echo $phone_number; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Date of Birth:</b> <?php echo $date_of_birth; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Address:</b> <?php echo $address; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Account Number:</b> <?php echo $account_number; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Capital Amount:</b> <?php echo $capital_amount; ?></label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Status:</b> <?php echo $status; ?> </label>
                </div>

                <div class="mb-3">
                    <label class="form-label"><b>Role:</b> <?php echo $role; ?></label>
                </div>

                <a href="dashboard.php" class="btn btn-primary">Back</a>
            </div>
        </div>

    </div>


</body>

</html>