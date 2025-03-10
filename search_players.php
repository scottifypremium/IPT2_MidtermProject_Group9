<?php
include 'db_connect2.php';

if (isset($_POST['searchQuery']) && isset($_POST['filterType'])) {
    $searchQuery = $_POST['searchQuery'];
    $filterType = $_POST['filterType'];

    // Prevent SQL Injection
    $allowedColumns = ['ml_id', 'player_name', 'ign', 'team_name', 'position'];
    if (!in_array($filterType, $allowedColumns)) {
        die("Invalid filter type.");
    }

    // Query to search players
    $sql = "SELECT * FROM players WHERE $filterType LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchQuery = "%$searchQuery%"; // Allow partial matching
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display results
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['ml_id']}</td>
                <td>{$row['team_name']}</td>
                <td>{$row['ign']}</td>
                <td>{$row['player_name']}</td>
                <td>{$row['position']}</td>
                <td>
                    <button onclick=\"viewPlayer({$row['id']})\">View</button>
                    <button onclick=\"editPlayer({$row['id']})\">Edit</button>
                    <button onclick=\"deletePlayer({$row['id']})\">Delete</button>
                </td>
            </tr>";
    }
}
?>
