<?php
$servername = "localhost";
$username = "root";
$password = "Zaek2009";
$dbname = "sports";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
return $conn;