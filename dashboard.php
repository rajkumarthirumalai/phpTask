<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/css/mdb.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/js/mdb.min.js"></script>
    <?php include 'header.php'; ?>

    <div class="container">
        <?php if (isset($_SESSION['deleted_message'])) { ?>
            <div id="deletedAlert" class="alert alert-danger" role="alert">
                <?php echo $_SESSION['deleted_message']; ?>
            </div>
            <?php
            // Unset the session variable after displaying the message
            unset($_SESSION['deleted_message']);
            ?>
        <?php } ?>
        <div class="row">
            <div class="col-md-6 mb-4">
                <label for="sortSelect" class="form-label">Sort by:</label>
                <select id="sortSelect" class="form-select" onchange="sortUsers(this)">
                    <option value="">Default</option>
                    <option value="id">ID</option>
                    <option value="firstname">First Name</option>
                    <option value="emailid">Email</option>
                    <option value="phone_number">Phone Number</option>
                    <option value="capital_amount">Capital Amount</option>
                    <option value="status">Status</option>
                </select>
            </div>
        </div>

        <table class="table">
            <thead>

                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Capital Amount</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("./db_config.php");
                function escape($value)
                {
                    global $conn;
                    return $conn->real_escape_string($value);
                }
                function getUsers($sortCriteria = "")
                {
                    global $conn;

                    $selectQuery = "SELECT 
                    id,
                    firstname,
                    lastname,
                    emailid,
                    phone_number,
                    date_of_birth,
                    address,
                    account_number,
                    capital_amount,
                    status,
                    role_id
                    FROM users";
                    if (!empty($sortCriteria)) {
                        $allowedCriteria = array("id", "firstname", "emailid", "phone_number", "capital_amount", "status");
                        if (in_array($sortCriteria, $allowedCriteria)) {
                            $selectQuery .= " ORDER BY " . $sortCriteria;
                        }
                    }

                    $result = $conn->query($selectQuery);
                    return $result;
                }

                // Sort and retrieve the user details
                $sortCriteria = isset($_GET['sort']) ? $_GET['sort'] : "";
                $result = getUsers($sortCriteria);

                // Loop through the users and display rows in the table
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $firstname = $row['firstname'];
                    $lastname = $row['lastname'];
                    $emailid = $row['emailid'];
                    $phone_number = $row['phone_number'];
                    $date_of_birth = $row['date_of_birth'];
                    $address = $row['address'];
                    $account_number = $row['account_number'];
                    $capital_amount = $row['capital_amount'];
                    $status = $row['status'];
                    $role_id = $row['role_id'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $id; ?>
                        </td>
                        <td>
                            <?php echo $firstname; ?>
                        </td>
                        <td>
                            <?php echo $emailid; ?>
                        </td>
                        <td>
                            <?php echo $phone_number; ?>
                        </td>
                        <td>
                            <?php echo $capital_amount; ?>
                        </td>
                        <td>
                            <?php echo $status; ?>
                        </td>
                        <td>
                            <div class="d-flex">
                                <form id="deleteForm_<?php echo $id; ?>" method="post" action="delete_user.php"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <a href="#" onclick="deleteUser(<?php echo $id; ?>)"><i class="fas fa-trash fa-lg"
                                            style="color: red;"></i></a>
                                </form>
                                <a href="view_user.php?id=<?php echo $id; ?>"><i class="fas fa-info-circle fa-lg px-3"
                                        style="color: blue;"></i></a>
                            </div>

                            <script>
                                function deleteUser(id) {
                                    if (confirm('Are you sure you want to delete this user?')) {
                                        document.getElementById('deleteForm_' + id).submit();
                                    }
                                }
                            </script>
                        </td>

                    </tr>
                    <?php
                }
                $conn->close();
                ?>
            </tbody>
        </table>

    </div>

    <script>
        function sortUsers(select) {
            var sortCriteria = select.value;
            window.location.href = "dashboard.php?sort=" + sortCriteria;
        }
        // Remove deleted message after 3 seconds
        setTimeout(function () {
            var deletedAlert = document.getElementById('deletedAlert');
            if (deletedAlert) {
                deletedAlert.remove();
            }
        }, 3000);
    </script>
</body>

</html>