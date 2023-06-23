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
    <title>User Roles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
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

        <!-- Add button to open create role modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            Add Role
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Options</th>
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
                    $status = $row['status'];
                ?>
                    <tr>
                        <td><?php echo $roleId; ?></td>
                        <td><?php echo $roleName; ?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRoleModal<?php echo $roleId; ?>">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal<?php echo $roleId; ?>">
                                Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Role Modal -->
                    <div class="modal fade" id="editRoleModal<?php echo $roleId; ?>" tabindex="-1" aria-labelledby="editRoleModalLabel<?php echo $roleId; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRoleModalLabel<?php echo $roleId; ?>">Edit Role</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Role edit form -->
                                    <form method="POST" action="update_role.php">
                                        <input type="hidden" name="roleId" value="<?php echo $roleId; ?>">
                                        <div class="mb-3">
                                            <label for="editRoleName<?php echo $roleId; ?>" class="form-label">Role Name</label>
                                            <input type="text" class="form-control" id="editRoleName<?php echo $roleId; ?>" name="roleName" value="<?php echo $roleName; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editStatus<?php echo $roleId; ?>" class="form-label">Status</label>
                                            <select class="form-select" id="editStatus<?php echo $roleId; ?>" name="status" required>
                                                <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
                                                <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Role Modal -->
                    <div class="modal fade" id="deleteRoleModal<?php echo $roleId; ?>" tabindex="-1" aria-labelledby="deleteRoleModalLabel<?php echo $roleId; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteRoleModalLabel<?php echo $roleId; ?>">Delete Role</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this role?</p>
                                    <form method="POST" action="delete_role.php">
                                        <input type="hidden" name="roleId" value="<?php echo $roleId; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Create Role Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Create New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Role creation form -->
                    <form method="POST" action="create_role.php">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="roleName" name="roleName" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
