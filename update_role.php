<?php
include("./db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input
    $roleId = $_POST['roleId'];
    $roleName = $_POST['roleName'];
    $status = $_POST['status'];

    // Update the role in the database
    $updateRoleQuery = "UPDATE roles SET role = '$roleName', status = '$status' WHERE id = $roleId";
    if ($conn->query($updateRoleQuery) === TRUE) {
        // Role updated successfully
        header("Location: user_roles.php");
        exit();
    } else {
        // Error occurred while updating role
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
