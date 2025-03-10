<?php
$conn = new mysqli("localhost", "root", "", "esports_db");
$stmt = $conn->prepare("INSERT INTO players (ml_id, team_name, ign, player_name, position) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $_POST['ml_id'], $_POST['team_name'], $_POST['ign'], $_POST['player_name'], $_POST['position']);
$stmt->execute();
?>
