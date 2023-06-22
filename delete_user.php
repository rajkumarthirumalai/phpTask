<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin.php");
    exit();
}

include("./db_config.php");

// Check if the user ID is provided
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the SQL query to delete the user
    $deleteUserQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteUserQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Set the session variable to store the deleted message
        $_SESSION['deleted_message'] = "User deleted successfully";
    } else {
        $_SESSION['deleted_message'] = "Error deleting user: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

// Redirect back to the dashboard
header("Location: dashboard.php");
exit();
?>
