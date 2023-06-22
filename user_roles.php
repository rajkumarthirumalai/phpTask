<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Roles</title>
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

    <div class="container">
        <h2>User Roles</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("./db_config.php");

                // Retrieve the list of roles
                $selectRolesQuery = "SELECT * FROM roles";
                $result = $conn->query($selectRolesQuery);

                // Loop through the roles and display rows in the table
                while ($row = $result->fetch_assoc()) {
                    $roleId = $row['id'];
                    $roleName = $row['role'];
                ?>
                    <tr>
                        <td><?php echo $roleId; ?></td>
                        <td><?php echo $roleName; ?></td>
                    </tr>
                <?php
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
