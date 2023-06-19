<?php
session_start();


// Check if the user ID is provided
if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Database connection details
    include("./db_config.php");

    // Prepare and execute the SQL query to delete the user
    $deleteUserQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteUserQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Close the database connection
    $conn->close();

    // Redirect back to the user management page
    header("Location: user_management.php");
    exit();
} else {
    // If the user ID is not provided, redirect back to the user management page
    header("Location: user_management.php");
    exit();
}
?>
