<?php
include 'header.php';
$conn = include 'connect.php';

$sql = "SELECT * FROM teams";
$stmt = $conn->prepare($sql);
$stmt->execute();
$teams = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $position = $_POST["position"];
    $team_id = $_POST["team"];

    if (strlen($name) < 2) {
        echo "Name must be at least 2 characters long";
        return;
    }
    if ($age < 18 || $age > 60) {
        echo "Age must be between 18 and 60";
        return;
    }

    $sql = "INSERT INTO players (name, age, position, team_id) VALUES ('$name', '$age', '$position', '$team_id')";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        header('Location: playersView.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<div class="container mt-5">
    <h1>Enter Player Details</h1>
    <form action="/addPlayer.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Player Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" required>
            <label for="position" class="form-label">Select a position</label>
            <select class="form-control" id="position" name="position" required>
                <option value="striker">Striker</option>
                <option value="midfielder">Midfielder</option>
                <option value="defender">Defender</option>
                <option value="goalkeeper">Goalkeeper</option>
            </select>
            <label for="team" class="form-label">Select a team</label>
            <select class="form-control" id="team" name="team" required>
                <?php foreach ($teams as $team) { ?>
                    <option value="<?php echo $team['id'] ?>"><?php echo $team['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>