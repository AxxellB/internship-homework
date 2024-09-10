<?php
include 'header.php';
$conn = include 'connect.php';
$sql = "SELECT * FROM players";

$stmt = $conn->prepare($sql);
$stmt->execute();
$players = $stmt->get_result();
?>

<div class="container mt-5">
    <div class="row">
        <?php foreach ($players as $player): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $player['name'] . " | age: " . $player['age']; ?></h5>

                        <a href="editPlayer.php?id=<?php echo $player['id']; ?>"
                           class="btn btn-warning btn-sm me-2">Edit</a>
                        <a href="deletePlayer.php?id=<?php echo $player['id']; ?>"
                           class="btn btn-danger btn-sm">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>