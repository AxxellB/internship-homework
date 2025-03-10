<?php

include 'header.php';

use App\App\Teacher;
use App\App\Student;
use App\App\Admin;

require_once 'src/Student.php';
require_once 'src/Teacher.php';
require_once 'src/Admin.php';

function getCurrentUser()
{
    if (file_exists('log.txt')) {
        return unserialize(file_get_contents('log.txt'));
    }
    return null;
}

$loggedInUser = getCurrentUser();

if ($loggedInUser === null || !$loggedInUser instanceof Admin) {
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectName = $_POST['subjectName'];
    $users = unserialize(file_get_contents("users.txt"));

    foreach ($users as $user) {
        if ($user->role == "student") {  // Assuming role is a public property
            $user->subjectsAndGrades[$subjectName] = [];
        }
    }

    $serializedUsers = serialize($users);
    file_put_contents('users.txt', $serializedUsers);

    header("Location: index.php");
    exit();
}

?>
<div class="container mt-5">
    <h1>Enter Team Details</h1>
    <form action="createSubject.php" method="post">
        <div class="mb-3">
            <label for="subjectName" class="form-label">Subject Name</label>
            <input type="text" class="form-control" id="subjectName" name="subjectName" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>