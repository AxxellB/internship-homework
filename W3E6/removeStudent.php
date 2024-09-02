<?php

use App\App\Student;
use App\App\Teacher;
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


$users = unserialize(file_get_contents("users.txt"));

$students = [];

foreach ($users as $user) {
    if ($user->role == "student") {
        $students[] = $user;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId'];

    $users = unserialize(file_get_contents("users.txt"));

    $users = array_filter($users, function ($user) use ($studentId) {
        return !($user->role == "student" && $user->id == $studentId);
    });

    $users = array_values($users);

    file_put_contents('users.txt', serialize($users));

    header("Location: index.php");
    exit();
}

include 'header.php';
?>
<div class="container">
    <h1>Remove Student</h1>
    <form action="removeStudent.php" method="post">
        <div class="mb-3">
            <label for="student" class="form-label">Select Student to Remove:</label>
            <select name="studentId" id="student" class="form-select">
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student->id; ?>">
                        <?php echo $student->firstName . " " . $student->lastName; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Remove Student</button>
    </form>
</div>