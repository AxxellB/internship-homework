<?php
$conn = include 'connect.php';
include 'header.php';

$sql = "SELECT t.name AS team_name, COUNT(p.id) AS player_count, AVG(p.age) AS avg_age
        FROM teams t
        LEFT JOIN players p ON t.id = p.team_id
        GROUP BY t.id, t.name";
$stmt = $conn->prepare($sql);
$stmt->execute();
$statistics = $stmt->get_result();
?>

<div class="container mt-5">
    <h1>Match Statistics</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Team Name</th>
            <th>Number of Players</th>
            <th>Average Age</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $statistics->fetch_assoc()) { ?>
            <?php if ($row['player_count'] > 0) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['team_name']); ?></td>
                    <td><?php echo $row['player_count']; ?></td>
                    <td><?php echo number_format($row['avg_age'], 2); ?></td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>
    <a href="viewMatches.php" class="btn btn-primary mt-3">Back to Matches List</a>
</div>
