<?php
$conn = include 'connect.php';
include 'header.php';
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "DELETE FROM matches WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $match_id);
        if ($stmt->execute()) {
            header("Location: viewMatches.php");
        } else {
            echo "Error deleting match: " . $conn->error;
        }
    }
}
?>
<div class="container mt-5">
    <h2>Delete Match</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <h3>Are you sure you want to delete match number <?php echo $match["id"] ?></h3>
        </div>
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="viewMatches.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>