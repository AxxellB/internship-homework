<?php
$conn = include 'connect.php';
include 'header.php';
$sql = "SELECT m.id, t1.name AS team1_name, t2.name AS team2_name, m.score1, m.score2, m.date
        FROM matches m
        JOIN teams t1 ON m.team1_id = t1.id
        JOIN teams t2 ON m.team2_id = t2.id
        ORDER BY m.date ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$matches = $stmt->get_result();
?>

<div class="container mt-5">
    <h1>Matches</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Team 1</th>
            <th>Score 1</th>
            <th>Score 2</th>
            <th>Team 2</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($match = $matches->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $match['id']; ?></td>
                <td><?php echo $match['team1_name']; ?></td>
                <td><?php echo $match['score1']; ?></td>
                <td><?php echo $match['score2']; ?></td>
                <td><?php echo $match['team2_name']; ?></td>
                <td><?php echo date('F j, Y', strtotime($match['date'])); ?></td>
                <td><a class="btn btn-warning" href="editMatch.php?id=<?php echo $match['id']; ?>">Edit</td>
                <td><a class="btn btn-danger" href="deleteMatch.php?id=<?php echo $match['id']; ?>">Delete</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
