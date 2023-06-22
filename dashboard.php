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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
        
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="script.js"></script>
</head>

<body>

    <?php include 'header.php'; ?>
    <?php if (isset($_SESSION['deleted_message'])) { ?>
        <div id="deletedAlert" class="alert alert-danger" role="alert">
            <?php echo $_SESSION['deleted_message']; ?>
        </div>
        <?php
        // Unset the session variable after displaying the message
        unset($_SESSION['deleted_message']);
        ?>
    <?php } ?>


    <div class="container my-5">
        <div class="row">
            <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
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
                            <tr class="py-5">
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
                                            <a href="#" onclick="deleteUser(<?php echo $id; ?>)"><i
                                                    class="bi bi-trash-fill px-3"
                                                    style="font-size: 1.5rem;color: #ED2939;"></i></a>
                                        </form>
                                        <a href="view_user.php?id=<?php echo $id; ?>"><i class="bi bi-eye-fill px-3"
                                                style="font-size: 1.5rem; color: RGB(2, 117, 216);"></i></a>
                                        <a href="edit_user.php?id=<?php echo $id; ?>"><i class="bi bi-pencil-square px-3"
                                                style="font-size: 1.5rem; color: RGB(92, 184, 92);"></i></a>
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
        </div>
        
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