<?php

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

if ($loggedInUser === null || !$loggedInUser instanceof Teacher) {
    header("Location: index.php");
    exit();
}


$usersData = unserialize(file_get_contents("users.txt"));
$students = array_filter($usersData, function ($user) {
    return $user instanceof Student;
});

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['studentId'])) {
    $selectedStudentId = $_POST['studentId'];
    header("Location: gradeStudentDetails.php?studentId=" . $selectedStudentId);
    exit();
}

include 'header.php';
?>

<div class="container mt-5">
    <h1>Grade a Student</h1>
    <form action="gradeStudent.php" method="post">
        <div class="mb-3">
            <label for="studentId" class="form-label">Select Student</label>
            <select class="form-select" id="studentId" name="studentId" required>
                <option value="" disabled selected>Select a student</option>
                <?php foreach ($students as $student) : ?>
                    <option value="<?php echo $student->id; ?>"><?php echo $student->firstName . " " . $student->lastName; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Select Student</button>
    </form>
</div>
