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

    // Set default values
    $status = "active";
    $role_id = 1;

    // Prepare and execute the SQL query to insert a new user
    $insertUserQuery = "INSERT INTO users (firstname, lastname, emailid, password, phone_number, date_of_birth, address_lane, city, state, country, zipcode, account_number, capital_amount, status, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertUserQuery);
    $stmt->bind_param("ssssssssssssdsd", $firstname, $lastname, $emailid, $hashedPassword, $phone_number, $date_of_birth, $address_lane, $city, $state, $country, $zipcode, $account_number, $capital_amount, $status, $role_id);


    if ($stmt->execute()) {
        $registrationSuccess = true;
    } else {
        $registrationSuccess = false;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Material Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <style>
        body {
            /* fallback for old browsers */
            background: #a1c4fd;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1))
        }

        @media (min-width: 992px) {
            .card-registration-2 .bg-indigo {
                border-radius: 15px;
            }
        }

        @media (max-width: 991px) {
            .card-registration-2 .bg-indigo {
                border-radius: 15px;
            }
        }

        label {
            color: black;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card card-registration card-registration-2 border-0 p-5" style="border-radius: 15px;">
            <?php if (isset($registrationSuccess) && $registrationSuccess) { ?>
                <div class="alert alert-success" role="alert">
                    Registration successful!
                </div>
            <?php } ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="mb-3 center" style="text-align:center">
                    <img src="./Public/log.jpg" alt="Logo" width="90" height="90"
                        style="border-radius:25px; margin-bottom:10px">
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                        <label for="firstname" class="form-label">First Name</label>

                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                        <label for="lastname" class="form-label">Last Name</label>

                    </div>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="emailid" name="emailid" required>
                    <label for="emailid" class="form-label">Email</label>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <label for="password" class="form-label">Password</label>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        <label for="phone_number" class="form-label">Phone Number</label>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="address_lane" name="address_lane" required>
                    <label for="address_lane" class="form-label">Address Lane</label>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 mb-4">
                        <input type="text" class="form-control" id="city" name="city" required>
                        <label for="city" class="form-label">City</label>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <input type="text" class="form-control" id="state" name="state" required>
                        <label for="state" class="form-label">State</label>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <input type="text" class="form-control" id="country" name="country" required>
                        <label for="country" class="form-label">Country</label>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                        <label for="zipcode" class="form-label">Zip Code</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                        <label for="account_number" class="form-label">Account Number</label>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <input type="number" step="0.01" class="form-control" id="capital_amount" name="capital_amount"
                            required>
                        <label for="capital_amount" class="form-label">Capital Amount</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark btn-lg" data-mdb-ripple-color="dark">Register</button>
            </form>

        </div>
    </div>


    <!-- Material Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Remove success message after 3 seconds
        setTimeout(function () {
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.classList.add('hide');
            }
        }, 3000);
    </script>

</body>

</html>