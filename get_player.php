<?php
$conn = new mysqli("localhost", "root", "", "esports_db");
$result = $conn->query("SELECT * FROM players WHERE id=" . $_GET['id']);
echo json_encode($result->fetch_assoc());
?>
