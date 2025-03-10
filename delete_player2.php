<?php
$conn = new mysqli("localhost", "root", "", "players2");
$conn->query("DELETE FROM players WHERE id=" . $_POST['id']);
?>
