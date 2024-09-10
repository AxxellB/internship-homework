<?php
include 'header.php';
$conn = include 'connect.php';
$sql = "SELECT * FROM teams";
$stmt = $conn->prepare($sql);
$stmt->execute();
$teams = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team1_id = $_POST['team1'];
    $team2_id = $_POST['team2'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $match_date = $_POST['match_date'];

    if ($score1 < 0 || $score2 < 0) {
        echo "Score must be a positive number";
        exit();
    }

    if ($team1_id == $team2_id) {
        echo "The teams must be different!";
        exit();
    }

    $sql = "INSERT INTO matches (team1_id, team2_id, score1, score2, date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiis", $team1_id, $team2_id, $score1, $score2, $match_date);

    if ($stmt->execute()) {
        echo "Match added successfully!";
        header("Location: viewMatches.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<div class="container mt-5">
    <h1>Enter Match Details</h1>
    <form action="/addMatch.php" method="post">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="team1" class="form-label">Team 1</label>
                <div class="input-group">
                    <select class="form-control" id="team1" name="team1" required>
                        <?php foreach ($teams as $team) { ?>
                            <option value="<?php echo $team['id'] ?>"><?php echo $team['name'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="number" class="form-control" id="score1" name="score1" placeholder="Score" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="team2" class="form-label">Team 2</label>
                <div class="input-group">
                    <select class="form-control" id="team2" name="team2" required>
                        <?php foreach ($teams as $team) { ?>
                            <option value="<?php echo $team['id'] ?>"><?php echo $team['name'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="number" class="form-control" id="score2" name="score2" placeholder="Score" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="match_date" class="form-label">Match Date and Time</label>
            <input type="date" class="form-control" id="match_date" name="match_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
