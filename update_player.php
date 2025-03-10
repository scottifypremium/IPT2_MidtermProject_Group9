<?php
include 'db_connect.php';

$stmt = $conn->prepare("UPDATE players SET ml_id=?, team_name=?, ign=?, player_name=?, position=? WHERE id=?");
$stmt->bind_param("sssssi", $_POST['ml_id'], $_POST['team_name'], $_POST['ign'], $_POST['player_name'], $_POST['position'], $_POST['id']);
$stmt->execute();
?>
