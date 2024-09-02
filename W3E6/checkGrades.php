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

if ($loggedInUser === null || !$loggedInUser instanceof Student) {
    echo "You must be logged in as a student to view grades.";
    exit();
}

$usersData = unserialize(file_get_contents("users.txt"));

$selectedStudent = null;
foreach ($usersData as $user) {
    if ($user instanceof Student && $user->id === $loggedInUser->id) {
        $selectedStudent = $user;
        break;
    }
}

if ($selectedStudent === null) {
    echo "Student not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subject'])) {
    $subject = $_POST['subject'];
    $grades = $selectedStudent->subjectsAndGrades[$subject] ?? [];
    $averageGrade = !empty($grades) ? array_sum($grades) / count($grades) : 0;
    include 'header.php';
    ?>

    <div class="container mt-5">
        <h1>Grades for Subject: <?php echo htmlspecialchars($subject); ?></h1>
        <h3>Grades:</h3>
        <?php if (!empty($grades)) : ?>
            <ul>
                <?php foreach ($grades as $grade) : ?>
                    <li><?php echo htmlspecialchars($grade); ?></li>
                <?php endforeach; ?>
            </ul>
            <h4>Average Grade: <?php echo number_format($averageGrade, 2); ?></h4>
        <?php else : ?>
            <p>No grades available for this subject.</p>
        <?php endif; ?>
        <a href="checkGrades.php" class="btn btn-primary">Back to My Grades</a>
    </div>

    <?php
    exit();
}

$subjects = array_keys($selectedStudent->subjectsAndGrades);

include 'header.php';
?>

<div class="container mt-5">
    <h1>View My Grades</h1>
    <form action="checkGrades.php" method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Select Subject</label>
            <select class="form-select" id="subject" name="subject" required>
                <option value="" disabled selected>Select a subject</option>
                <?php foreach ($subjects as $subject) : ?>
                    <option value="<?php echo htmlspecialchars($subject); ?>"><?php echo htmlspecialchars($subject); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">View Grades</button>
    </form>
</div>
