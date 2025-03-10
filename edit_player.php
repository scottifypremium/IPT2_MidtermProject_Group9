<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $ml_id = $_POST['ml_id'];
    $team_name = $_POST['team_name'];
    $ign = $_POST['ign'];
    $player_name = $_POST['player_name'];
    $position = $_POST['position'];

    $stmt = $conn->prepare("UPDATE players SET ml_id=?, team_name=?, ign=?, player_name=?, position=? WHERE id=?");
    $stmt->bind_param("sssssi", $ml_id, $team_name, $ign, $player_name, $position, $id);

    if ($stmt->execute()) {
        echo "Player updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
