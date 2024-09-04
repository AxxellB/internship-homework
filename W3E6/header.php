<?php

use App\App\Student;
use App\App\Teacher;
use App\App\Admin;

require_once 'src/Student.php';
require_once 'src/Teacher.php';
require_once 'src/Admin.php';

$userData = unserialize(file_get_contents("log.txt"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
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
            <?php if ($userData) { ?>
                <?php if ($userData->role == "admin") { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="studentDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Student Menu
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="studentDropdown">
                            <li><a class="dropdown-item" href="./createSubject.php">Create a subject</a></li>
                            <li><a class="dropdown-item" href="./createStudent.php">Create a student</a></li>
                            <li><a class="dropdown-item" href="./removeSubject.php">Remove a subject</a></li>
                            <li><a class="dropdown-item" href="./removeStudent.php">Remove a student</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="instructorDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Instructor Menu
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="instructorDropdown">
                            <li><a class="dropdown-item" href="./createTeacher.php">Create a teacher</a></li>
                            <li><a class="dropdown-item" href="./removeTeacher.php">Remove a teacher</a></li>
                        </ul>
                    </li>
                <?php } elseif ($userData->role == "teacher") { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="instructorDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Instructor Menu
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="instructorDropdown">
                            <li><a class="dropdown-item" href="./gradeStudent.php">Grade a student</a></li>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="instructorDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Student Menu
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="instructorDropdown">
                            <li><a class="dropdown-item" href="./checkGrades.php">Check grades</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="">You are logged in
                        as: <?php echo $userData->username; ?></a>
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
</body>
</html>
