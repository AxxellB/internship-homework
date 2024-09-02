<?php

use App\App\Student;
use App\App\Teacher;
use App\App\Admin;

require_once 'src/Student.php';
require_once 'src/Teacher.php';
require_once 'src/Admin.php';

$usersData = unserialize(file_get_contents("users.txt"));

$allSubjects = [];

foreach ($usersData as $user) {
    if ($user instanceof Student) {
        foreach ($user->subjectsAndGrades as $subject => $grades) {
            $allSubjects[] = $subject;
        }
    } elseif ($user instanceof Teacher) {
        foreach ($user->subjects as $subject) {
            $allSubjects[] = $subject;
        }
    }
}

$allSubjects = array_unique($allSubjects);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usersData = unserialize(file_get_contents("users.txt"));
    $lastUser = end($usersData);
    $newUserId = $lastUser->id + 1;

    $subjects = $_POST['subjects'] ?? [];
    $subjectsAndGrades = array_fill_keys($subjects, []);

    $newStudent = new Student($newUserId, $_POST['username'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $subjectsAndGrades);
    $usersData[] = $newStudent;
    $serializedUsers = serialize($usersData);

    file_put_contents('users.txt', $serializedUsers);
    header("Location: index.php");
    exit();
}

include 'header.php';
?>
<div class="container mt-5">
    <h1>Create Student</h1>
    <form action="createStudent.php" method="post">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="subjects" class="form-label">Subjects</label>
            <div id="subjectFields">
                <div class="input-group mb-3">
                    <select class="form-select" name="subjects[]" multiple required>
                        <?php
                        foreach ($allSubjects as $subject) {
                            echo "<option value=\"{$subject}\">{$subject}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Student</button>
    </form>
</div>
