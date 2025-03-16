<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the POST request
    $ml_id = $_POST['ml_id'];
    $team_name = $_POST['team_name'];
    $ign = $_POST['ign'];
    $player_name = $_POST['player_name'];
    $position = $_POST['position'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO players (ml_id, team_name, ign, player_name, position) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssss", $ml_id, $team_name, $ign, $player_name, $position);

    // Execute the statement
    if ($stmt->execute()) {
        echo "success"; // Return "success" to match the JavaScript expectation
    } else {
        echo "error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>