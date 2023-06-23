<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin.php");
    exit();
}
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <?php if (isset($_SESSION['registrationSuccess']) && $_SESSION['registrationSuccess']) { ?>
            <div id="successAlert" class="alert alert-success" role="alert">
                Update successful!
            </div>
            <?php unset($_SESSION['registrationSuccess']); ?>
            <!-- Unset the success flag after displaying the message -->
        <?php } ?>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2>User Details</h2>
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <tr>
                            <td>First Name:</td>
                            <td>
                                <?php echo $firstname; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td>
                                <?php echo $lastname; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>
                                <?php echo $emailid; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td>
                            <td>
                                <?php echo $phone_number; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth:</td>
                            <td>
                                <?php echo $date_of_birth; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <?php echo $address; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Account Number:</td>
                            <td>
                                <?php echo $account_number; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Capital Amount:</td>
                            <td>
                                <?php echo $capital_amount; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td>
                                <?php echo $status; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Role:</td>
                            <td>
                                <?php echo $role; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <a href="dashboard.php" class="btn btn-danger">Back</a>
                <a href="edit_user.php?id=<?php echo $userId; ?>" class="btn btn-success">Edit</a>
            </div>
        </div>

    </div>

    <script>
        // Automatically hide the success alert after 3 seconds
        setTimeout(function () {
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 2000);
    </script>
</body>

</html>