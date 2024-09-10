<?php
include 'header.php';
$conn = include 'connect.php';
$sql = "SELECT * FROM teams";

$stmt = $conn->prepare($sql);
$stmt->execute();
$teams = $stmt->get_result();
?>

<div class="container mt-5">
    <div class="row">
        <?php foreach ($teams as $team): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $team['name']; ?></h5>
                        <a href="editTeam.php?id=<?php echo $team['id']; ?>"
                           class="btn btn-warning btn-sm me-2">Edit</a>
                        <a href="deleteTeam.php?id=<?php echo $team['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>