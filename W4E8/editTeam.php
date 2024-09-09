<?php
$conn = include 'connect.php';
include 'header.php';
if (isset($_GET['id'])) {
    $team_id = $_GET['id'];

    $sql = "SELECT * FROM teams WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $team_id);
    $stmt->execute();
    $team = $stmt->get_result()->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $team_name = $_POST['team_name'];
        $city = $_POST['city'];

        $sql = "UPDATE teams SET name = ?, city = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $team_name, $city, $team_id);

        if ($stmt->execute()) {
            header("Location: viewTeams.php");
            exit();
        } else {
            echo "Error updating team: " . $conn->error;
        }
    }
} else {
    echo "No team selected!";
    exit();
}
?>
<div class="container mt-5">
    <h2>Edit Team</h2>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="team_name" class="form-label">Team Name</label>
            <input type="text" class="form-control" id="team_name" name="team_name"
                   value="<?php echo $team['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city"
                   value="<?php echo $team['city']; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="viewTeams.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
