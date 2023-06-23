<?php
include("./db_config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input
    $roleId = $_POST['roleId'];

    // Delete the role from the database
    $deleteRoleQuery = "DELETE FROM roles WHERE id = $roleId";
    if ($conn->query($deleteRoleQuery) === TRUE) {
        // Role deleted successfully
        header("Location: user_roles.php");
        exit();
    } else {
        // Error occurred while deleting role
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
