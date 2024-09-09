<?php
$conn = include 'connect.php';
include 'header.php';

if (isset($_GET['id'])) {
    $team_id = $_GET['id'];
    $sql = "SELECT * FROM teams where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $team_id);
    $stmt->execute();
    $team = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "DELETE FROM teams where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $team_id);
        if ($stmt->execute()) {
            header("Location: viewTeams.php");
            exit();
        } else {
            echo "Error deleting team: " . $conn->error;
        }
    }
} else {
    echo "No team selected!";
    exit();
}
?>

<div class="container mt-5">
    <h2>Delete Team</h2>

    <form action="" method="POST">
        <div class="mb-3">
            <h3>Are you sure you want to delete team <?php echo $team["name"] ?></h3>
        </div>
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="viewTeams.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
