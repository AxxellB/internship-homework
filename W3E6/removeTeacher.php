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


function getTeachers($usersData)
{
    $teachers = [];
    foreach ($usersData as $user) {
        if ($user instanceof Teacher) {
            $teachers[] = $user;
        }
    }
    return $teachers;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teacherId'])) {
    $usersData = unserialize(file_get_contents("users.txt"));
    $teacherIdToRemove = $_POST['teacherId'];

    $usersData = array_filter($usersData, function ($user) use ($teacherIdToRemove) {
        return !($user instanceof Teacher && $user->id == $teacherIdToRemove);
    });

    $serializedUsers = serialize($usersData);
    file_put_contents('users.txt', $serializedUsers);

    header("Location: index.php");
    exit();
}

$usersData = unserialize(file_get_contents("users.txt"));
$teachers = getTeachers($usersData);

include 'header.php';
?>

<div class="container mt-5">
    <h1>Remove Teacher</h1>
    <form action="removeTeacher.php" method="post">
        <div class="mb-3">
            <label for="teacher" class="form-label">Select Teacher to Remove</label>
            <select class="form-select" id="teacher" name="teacherId" required>
                <option value="" disabled selected>Select a teacher</option>
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher->id; ?>">
                        <?php echo $teacher->firstName . ' ' . $teacher->lastName; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Remove Teacher</button>
    </form>
</div>
