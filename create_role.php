<?php
include("./db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input
    $roleName = $_POST['roleName'];
    $status = $_POST['status'];

    // Insert the new role into the database
    $insertRoleQuery = "INSERT INTO roles (role, status) VALUES ('$roleName', '$status')";
    if ($conn->query($insertRoleQuery) === TRUE) {
        // Role created successfully
        header("Location: user_roles.php");
        exit();
    } else {
        // Error occurred while creating role
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
