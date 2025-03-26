<?php
$conn = new mysqli("localhost", "root", "", "players2");
$result = $conn->query("SELECT * FROM players WHERE id=" . $_GET['id']);
echo json_encode($result->fetch_assoc());
?>
