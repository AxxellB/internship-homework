<?php
include 'header.php';
$conn = include 'connect.php';

$sql = "SELECT * FROM players";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<h1>Home</h1>
