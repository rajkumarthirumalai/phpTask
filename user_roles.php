<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/css/mdb.min.css" rel="stylesheet" />
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@3.11.0/js/mdb.min.js"></script>
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
