<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userData = unserialize(file_get_contents("log.txt"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="static/styles/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Student</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Instructor</a>
            </li>
            <?php if ($userData) { ?>
                <li class="nav-item">
                    You are logged as: <?php echo $userData["username"]; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/logout.php">Log out</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/login.php">Login</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>