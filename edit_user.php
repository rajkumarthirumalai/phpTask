<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin.php");
    exit();
}
require_once "./db_config.php";

$selectRolesQuery = "SELECT * FROM roles";
$rolesResult = $conn->query($selectRolesQuery);


if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Retrieve user data
    $selectUserQuery = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($selectUserQuery);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $firstname = $user["firstname"];
        $lastname = $user["lastname"];
        $emailid = $user["emailid"];
        $phone_number = $user["phone_number"];
        $address = $user["address"];
        $date_of_birth = $user["date_of_birth"];
        $city = $user["city"];
        $country = $user["country"];
        $zipcode = $user["zipcode"];
        $capital_amount = $user["capital_amount"];
        $account_number = $user["account_number"];
        $role_id = $user["role_id"]; // Added role_id

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $updatedFirstname = $_POST["firstname"];
            $updatedLastname = $_POST["lastname"];
            $updatedPhoneNumber = $_POST["phone_number"];
            $updatedAddress = $_POST["address"];
            $updatedDateOfBirth = $_POST["date_of_birth"];
            $updatedCity = $_POST["city"];
            $updatedCountry = $_POST["country"];
            $updatedZipcode = $_POST["zipcode"];
            $updatedCapitalAmount = $_POST["capital_amount"];
            $updatedAccountNumber = $_POST["account_number"];
            $updatedRoleId = $_POST["role_id"]; // Added role_id

            $updateUserQuery = "UPDATE users SET firstname = ?, lastname = ?, phone_number = ?, address = ?, date_of_birth = ?, city = ?, country = ?, zipcode = ?, capital_amount = ?, account_number = ?, role_id = ? WHERE id = ?";
            $stmt = $conn->prepare($updateUserQuery);
            $stmt->bind_param("ssssssssssis", $updatedFirstname, $updatedLastname, $updatedPhoneNumber, $updatedAddress, $updatedDateOfBirth, $updatedCity, $updatedCountry, $updatedZipcode, $updatedCapitalAmount, $updatedAccountNumber, $updatedRoleId, $id);

            if ($stmt->execute()) {
                $_SESSION['registrationSuccess'] = true; // Set registration success flag in session
                header("Location: view_user.php?id=" . $id);
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }

        // Retrieve roles list
      
    } else {
        die($mysql->error);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "User ID not provided in the URL.";
    exit();
}
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <a href="dashboard.php" class="btn btn-dark btn-lg " data-mdb-ripple-color="dark">Back</a>
        <div class="card card-registration card-registration-2 border-0 p-5" style="border-radius: 15px;">

            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST">
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            value="<?php echo $firstname; ?>" required>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"
                            value="<?php echo $lastname; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                            value="<?php echo $phone_number; ?>" required>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                            value="<?php echo $date_of_birth; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address Lane</label>
                    <input type="text" class="form-control" id="address" name="address"
                        value="<?php echo $address; ?>" required>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>"
                            required>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country"
                            value="<?php echo $country; ?>" required>
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <label for="zipcode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode"
                            value="<?php echo $zipcode; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number"
                            value="<?php echo $account_number; ?>" required>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="capital_amount" class="form-label">Capital Amount</label>
                        <input type="number" step="0.01" class="form-control" id="capital_amount"
                            value="<?php echo $capital_amount; ?>" name="capital_amount" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mb-4">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-control" id="role_id" name="role_id">
                            <?php
                            var_dump( $rolesResult );
                            print_r($rolesResult) ;
                            while ($row = $rolesResult->fetch_assoc()) {
                                
                                $role_id = $row['id'];
                                $role_name = $row['role'];
                                $selected = ($role_id == $user['role_id']) ? "selected" : "";
                                echo "<option value=\"$role_id\" $selected>$role_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="submit" value="Update User" class="btn btn-primary">
            </form>
        </div>
    </div>
</body>

</html>