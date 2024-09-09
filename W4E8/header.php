<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports System</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="static/styles/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Home</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="teamsDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Teams Menu
                </a>
                <ul class="dropdown-menu" aria-labelledby="teamsDropdown">
                    <li><a class="dropdown-item" href="./createTeam.php">Create a team</a></li>
                    <li><a class="dropdown-item" href="./viewTeams.php">View Teams</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="playersDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Players Menu
                </a>
                <ul class="dropdown-menu" aria-labelledby="playersDropdown">
                    <li><a class="dropdown-item" href="./addPlayer.php">Add player</a></li>
                    <li><a class="dropdown-item" href="./playersView.php">View players</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="matchesDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Matches Menu
                </a>
                <ul class="dropdown-menu" aria-labelledby="matchesDropdown">
                    <li><a class="dropdown-item" href="./addMatch.php">Create match</a></li>
                    <li><a class="dropdown-item" href="./viewMatches.php">View matches</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./statisticsMatch.php">Match Statistics</a>
            </li>
        </ul>
    </div>
</nav>
