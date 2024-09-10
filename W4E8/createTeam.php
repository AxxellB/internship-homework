<?php
include 'header.php';
$conn = include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$_POST['teamName'] || !$_POST['city']) {
        echo "Please enter a team name and a city";
        exit;
    }
    $teamName = $_POST['teamName'];
    $city = $_POST['city'];

    $sql = "INSERT INTO teams (name, city) VALUES ('$teamName', '$city')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<div class="container mt-5">
    <h1>Enter Team</h1>
    <form action="/createTeam.php" method="post">
        <div class="mb-3">
            <label for="teamName" class="form-label">Team Name</label>
            <input type="text" class="form-control" id="teamName" name="teamName" required>
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>