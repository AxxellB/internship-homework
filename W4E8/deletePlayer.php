<?php
$conn = include 'connect.php';
include 'header.php';

if (isset($_GET['id'])) {
    $player_id = $_GET['id'];
    $sql = "SELECT * FROM players where id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $player_id);
    $stmt->execute();
    $player = $stmt->get_result()->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "DELETE FROM players where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $player_id);
        if ($stmt->execute()) {
            header("Location: playersView.php");
            exit();
        } else {
            echo "Error deleting player: " . $conn->error;
        }
    }
} else {
    echo "No player selected!";
    exit();
}
?>

<div class="container mt-5">
    <h2>Delete Player</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <h3>Are you sure you want to delete player <?php echo $player["name"] ?></h3>
        </div>
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="playersView.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
