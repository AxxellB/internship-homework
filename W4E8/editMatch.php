<?php
include 'header.php';
$conn = include 'connect.php';

if (isset($_GET['id'])) {
    $match_id = $_GET['id'];

    $sql = "SELECT m.id, t1.id AS team1_id, t2.id AS team2_id, m.score1, m.score2, m.date
            FROM matches m
            JOIN teams t1 ON m.team1_id = t1.id
            JOIN teams t2 ON m.team2_id = t2.id
            WHERE m.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $match_id);
    $stmt->execute();
    $match = $stmt->get_result()->fetch_assoc();
    $formatted_date = date('Y-m-d', strtotime($match['date']));

    $sql = "SELECT id, name FROM teams";
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


        $sql = "UPDATE matches 
                SET team1_id = ?, team2_id = ?, score1 = ?, score2 = ?, date = ?
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiisi", $team1_id, $team2_id, $score1, $score2, $match_date, $match_id);

        if ($stmt->execute()) {
            header("Location: viewMatches.php");
            exit();
        } else {
            echo "Error updating match: " . $conn->error;
        }
    }
} else {
    echo "No match selected!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Match</title>
</head>
<body>
<div class="container mt-5">
    <h1>Edit Match Details</h1>
    <form action="" method="post">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="team1" class="form-label">Team 1</label>
                <div class="input-group">
                    <select class="form-control" id="team1" name="team1" required>
                        <?php while ($team = $teams->fetch_assoc()) { ?>
                            <option value="<?php echo $team['id']; ?>" <?php echo ($team['id'] == $match['team1_id']) ? 'selected' : ''; ?>>
                                <?php echo $team['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="number" class="form-control" id="score1" name="score1" placeholder="Score" required
                           value="<?php echo $match['score1']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <label for="team2" class="form-label">Team 2</label>
                <div class="input-group">
                    <select class="form-control" id="team2" name="team2" required>
                        <?php $teams->data_seek(0); ?>
                        <?php while ($team = $teams->fetch_assoc()) { ?>
                            <option value="<?php echo $team['id']; ?>" <?php echo ($team['id'] == $match['team2_id']) ? 'selected' : ''; ?>>
                                <?php echo $team['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="number" class="form-control" id="score2" name="score2" placeholder="Score" required
                           value="<?php echo $match['score2']; ?>">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="match_date" class="form-label">Match Date</label>
            <input type="date" class="form-control" id="match_date" name="match_date" required
                   value="<?php echo $formatted_date; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Match</button>
    </form>
</div>
</body>
</html>
