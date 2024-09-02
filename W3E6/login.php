<?php

use App\App\Student;
use App\App\Teacher;
use App\App\Admin;

require_once 'src/Student.php';
require_once 'src/Teacher.php';
require_once 'src/Admin.php';

$subjectsAndGrades = [
    "maths" => [5, 4, 6],
    "history" => [3, 5, 2],
];

$subjects = [
    "maths", "history"
];

$users = unserialize(file_get_contents("users.txt"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($users as $user) {
        if (login($_POST["username"], $_POST["password"], $user)) {
            file_put_contents("log.txt", serialize($user));
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