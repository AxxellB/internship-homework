<?php
include 'header.php';
$conn = include 'connect.php';

if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    $sql = "SELECT * FROM players WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $player_id);
    $stmt->execute();
    $player = $stmt->get_result()->fetch_assoc();

    $sql = "SELECT * FROM teams";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $teams = $stmt->get_result();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST["name"];
        $age = $_POST["age"];
        $position = $_POST["position"];
        $team_id = $_POST["team"];

        $sql = "UPDATE players SET name = ?, age = ?, position = ?, team_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $name, $age, $position, $team_id, $player_id);

        if ($stmt->execute()) {
            header("Location: playersView.php");
            exit();
        } else {
            echo "Error updating player: " . $conn->error;
        }
    }
} else {
    echo "No player selected!";
    exit();
}
?>
<div class="container mt-5">
    <h1>Edit Player Details</h1>
    <form action="" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Player Name</label>
            <input type="text" class="form-control" id="name" name="name" required
                   value="<?php echo $player['name']; ?>">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" required
                   value="<?php echo $player['age']; ?>">
            <label for="position" class="form-label">Select a position</label>
            <select class="form-control" id="position" name="position" required>
                <option value="striker" <?php echo ($player['position'] == 'striker') ? 'selected' : ''; ?> >Striker
                </option>
                <option value="midfielder" <?php echo ($player['position'] == 'midfielder') ? 'selected' : ''; ?> >
                    Midfielder
                </option>
                <option value="defender" <?php echo ($player['position'] == 'defender') ? 'selected' : ''; ?> >Defender
                </option>
                <option value="goalkeeper" <?php echo ($player['position'] == 'goalkeeper') ? 'selected' : ''; ?> >
                    Goalkeeper
                </option>
            </select>
            <label for="team" class="form-label">Select a team</label>
            <select class="form-control" id="team" name="team" required>
                <?php foreach ($teams as $team) { ?>
                    <option value="<?php echo $team['id'] ?>" <?php echo ($player['team_id'] == $team['id']) ? 'selected' : ''; ?>>
                        <?php echo $team['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>