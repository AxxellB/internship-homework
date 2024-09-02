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

$allSubjects = [];

foreach ($users as $user) {
    if ($user->role == "student") {
        foreach ($user->subjectsAndGrades as $subject => $grades) {
            if (!in_array($subject, $allSubjects)) {
                $allSubjects[] = $subject;
            }
        }
    } elseif ($user->role == "teacher") {
        foreach ($user->subjects as $subject) {
            if (!in_array($subject, $allSubjects)) {
                $allSubjects[] = $subject;
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subjectName = $_POST['subjectName'];

    $users = unserialize(file_get_contents("users.txt"));

    foreach ($users as $user) {
        if ($user->role == "student" && isset($user->subjectsAndGrades[$subjectName])) {
            unset($user->subjectsAndGrades[$subjectName]);
        } elseif ($user->role == "teacher") {
            $user->subjects = array_filter($user->subjects, function ($subject) use ($subjectName) {
                return $subject !== $subjectName;
            });
        }
    }

    file_put_contents('users.txt', serialize($users));

    header("Location: index.php");
    exit();
}
include 'header.php'
?>

<div class="container">
    <h1>Remove Subject</h1>
    <form action="removeSubject.php" method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Select Subject to Remove:</label>
            <select name="subjectName" id="subject" class="form-select">
                <?php foreach ($allSubjects as $subject): ?>
                    <option value="<?php echo $subject; ?>"><?php echo $subject; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Remove Subject</button>
    </form>
</div>
