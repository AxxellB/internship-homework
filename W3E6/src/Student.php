<?php
namespace App\App;
include_once 'User.php';
class Student extends User
{
    public array $subjectsAndGrades;
    public string $role = "student";

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName, array $subjectsAndGrades){
        parent::__construct($id, $username, $password, $firstName, $lastName);
        $this->subjectsAndGrades = $subjectsAndGrades;
    }

    public function run(){
        echo "Student menu\n";
        echo "1. Check grades for a subject\n";
        echo "2. Log out\n";

        $fin = fopen("php://stdin", "r");
        echo "Enter an option from 1 to 7: ";
        $inputOption = trim(fgets($fin));
        if ($inputOption == "1") {
            $this->checkGrade();
        }
        else if ($inputOption == "2") {
            $this->logOut();
        }
    }

    public function checkGrade(){
        echo "Your subjects are:\n";
        $keys = array_keys($this->subjectsAndGrades);
        $subjectNumber = 0;
        foreach ($keys as $key) {
            ++$subjectNumber;
            echo "$subjectNumber. " . $key . PHP_EOL;
        }
        echo "Please select a subject id to see your grades for it:\n";
        $fin = fopen("php://stdin", "r");
        $input = trim(fgets($fin));
        while ($input > $subjectNumber || $input < 1) {
            echo "Invalid subject id! Please enter a valid id:\n";
            $fin = fopen("php://stdin", "r");
            $input = trim(fgets($fin));
        }
        $currentIndex = $input - 1;
        $currentSubjectName = $keys[$currentIndex];
        $currentSubjectGrades = $this->subjectsAndGrades[$keys[$currentIndex]];
        $currentGradesAverage = array_sum($currentSubjectGrades) / count($currentSubjectGrades);
        echo "Your $currentSubjectName grades are:\n";
        echo Student . phpimplode(", ", $currentSubjectGrades) . PHP_EOL;
        echo "Average: " . round($currentGradesAverage, 2) . PHP_EOL;
        $this->run();
    }
}