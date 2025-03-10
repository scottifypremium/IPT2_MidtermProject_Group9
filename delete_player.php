<?php
$conn = new mysqli("localhost", "root", "", "esports_db");
$conn->query("DELETE FROM players WHERE id=" . $_POST['id']);
?>
