<?php

use App\App\Student;
use App\App\Teacher;
use App\App\Admin;

require 'src/Student.php';
require 'src/Teacher.php';
require 'src/Admin.php';

$subjectsAndGrades = [
    "maths" => [5, 4, 6],
    "history" => [3, 5, 2],
];

$subjects = [
    "maths", "history"
];

$s = new Student(1, "Test", "test1", "Angel", "Angelov", $subjectsAndGrades);
$t = new Teacher(2, "Test", "test2", "Ivan", "Ivanov", $subjects);
$a = new Admin(3, "Test", "test3", "Georgi", "Georgiev");
$users = [$s, $t, $a];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($users as $user) {
        if (login($_POST["username"], $_POST["password"], $user)) {
            file_put_contents("log.txt", serialize($_POST));
            header("Location: index.php");
            exit();
        }
    }
}

function login($username, $password, $user): bool
{
    if ($username == $user->username && $password == $user->password) {
        return true;
    }
    return false;
}

include 'header.php';
?>
<div class="container">
    <h1>Login</h1>
    <form action="login.php" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">
            </label>
            <input id="username" name="username" placeholder="Username" class="form-control">
            <label for="password" class="form-label">
            </label>
            <input id="password" name="password" placeholder="Password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary" id="login-submit-btn">Login</button>
    </form>
</div>