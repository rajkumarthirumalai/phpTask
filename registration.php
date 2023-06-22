<?php
// Start the session

use Random\Engine\Secure;

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


    if (isset($_POST['g-recaptcha-response'])) {
        echo $_POST['g-recaptcha-response'];
        $token = $_POST['g-recaptcha-response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'Secret' => '6Lc_WLomAAAAAKzzKf3AYntQET-l3lnRp2O-urgX',
            'response' => $token
        );
    }
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);




    // Hash the password
    if ($response->success && $response->score >= 0.5) {
        echo json_encode(array('success' => true, "msg" => "You are not a robot!", "response" => $response));
        
        // Include the database configuration file
        require_once "./db_config.php";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
    } else {
        echo json_encode(array('success' => false, "msg" => "You are a robot!", "response" => $response));
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc_WLomAAAAAMj8QtCxAI5Tn73oTY-I3yR2DG7f"></script>
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="demo-form">
                <div class="mb-3 center" style="text-align:center">
                    <img src="./Public/log.jpg" alt="Logo" width="90" height="90"
                        style="border-radius:25px; margin-bottom:10px">
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="emailid" class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailid" name="emailid" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address_lane" class="form-label">Address Lane</label>
                    <input type="text" class="form-control" id="address_lane" name="address_lane" required>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="zipcode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="capital_amount" class="form-label">Capital Amount</label>
                        <input type="number" step="0.01" class="form-control" id="capital_amount" name="capital_amount"
                            required>
                    </div>
                </div>
                <button class="g-recaptcha  btn btn-dark btn-lg" data-mdb-ripple-color="dark"
                    data-sitekey="6Lc_WLomAAAAAMj8QtCxAI5Tn73oTY-I3yR2DG7f" data-callback='onSubmit'
                    data-action='submit'>Submit</button>
            </form>
        </div>
    </div>

    <!-- Material Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Remove success message after 3 seconds
        function onSubmit(token) {
            document.getElementById("demo-form").submit();
        }
        setTimeout(function () {
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.classList.add('hide');
            }
        }, 3000);
    </script>
</body>

</html>