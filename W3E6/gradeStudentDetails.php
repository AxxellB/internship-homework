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
$selectedStudentId = isset($_GET['studentId']) ? (int)$_GET['studentId'] : 0;
$selectedStudent = null;

foreach ($usersData as $user) {
    if ($user instanceof Student && $user->id == $selectedStudentId) {
        $selectedStudent = $user;
        break;
    }
}

if (!$selectedStudent) {
    echo "Student not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subject']) && isset($_POST['grade'])) {
    $subject = $_POST['subject'];
    $grade = (int)$_POST['grade'];

    if ($grade < 2 || $grade > 6) {
        echo "Grade must be between 2 and 6.";
        exit();
    }

    if (array_key_exists($subject, $selectedStudent->subjectsAndGrades)) {
        $selectedStudent->subjectsAndGrades[$subject][] = $grade;
        file_put_contents('users.txt', serialize($usersData));
        header("Location: index.php");
    } else {
        echo "Subject not found for this student.";
    }
    exit();
}

$subjects = $selectedStudent->subjectsAndGrades;

include 'header.php';
?>

<div class="container mt-5">
    <h1>Grade Student: <?php echo $selectedStudent->firstName . " " . $selectedStudent->lastName; ?></h1>
    <form action="gradeStudentDetails.php?studentId=<?php echo $selectedStudentId; ?>" method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Select Subject</label>
            <select class="form-select" id="subject" name="subject" required>
                <option value="" disabled selected>Select a subject</option>
                <?php foreach ($subjects as $subject => $grades) : ?>
                    <option value="<?php echo htmlspecialchars($subject); ?>"><?php echo htmlspecialchars($subject); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="grade" class="form-label">Enter Grade (2-6)</label>
            <input type="number" class="form-control" id="grade" name="grade" min="2" max="6" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Grade</button>
    </form>
</div>
