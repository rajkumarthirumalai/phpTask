<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $emailid = $_POST["emailid"];
    $password = $_POST["password"];
    $phone_number = $_POST["phone_number"];
    $date_of_birth = $_POST["date_of_birth"];
    $address_lane = $_POST["address_lane"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $zipcode = $_POST["zipcode"];
    $account_number = $_POST["account_number"];
    $capital_amount = $_POST["capital_amount"];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    include("./db_config.php");

    // Check if the email already exists
    $checkEmailQuery = "SELECT id FROM users WHERE emailid = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $emailid);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email already exists";
        exit();
    }

    // Set default values
    $status = "active";
    $role_id = 1;

    // Prepare and execute the SQL query to insert a new user
    $insertUserQuery = "INSERT INTO users (firstname, lastname, emailid, password, phone_number, date_of_birth, address, account_number, capital_amount, status, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertUserQuery);
    $address = "$address_lane, $city, $state, $country, $zipcode";
    $stmt->bind_param("ssssssssdss", $firstname, $lastname, $emailid, $hashedPassword, $phone_number, $date_of_birth, $address, $account_number, $capital_amount, $status, $role_id);

    if ($stmt->execute()) {
        echo "User registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <!-- Material Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <img src="./Public/log.jpg" alt="Logo" width="90" height="90">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailid" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailid" name="emailid" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="mb-3">
                        <label for="address_lane" class="form-label">Address Lane</label>
                        <input type="text" class="form-control" id="address_lane" name="address_lane" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    <div class="mb-3">
                        <label for="zipcode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                    </div>
                    <div class="mb-3">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="capital_amount" class="form-label">Capital Amount</label>
                        <input type="number" step="0.01" class="form-control" id="capital_amount" name="capital_amount" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Material Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>