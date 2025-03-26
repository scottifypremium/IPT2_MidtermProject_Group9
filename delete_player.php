<?php
include 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Get the player ID from the request

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM players WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameter
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "success"; // Return "success" if the deletion is successful
    } else {
        echo "error: " . $stmt->error; // Return an error message if the deletion fails
    }

    // Close the statement
    $stmt->close();
} else {
    echo "error: Invalid request method.";
}

// Close the connection
$conn->close();
?>