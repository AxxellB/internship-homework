<?php
namespace App\App;

class Teacher extends User
{
    public $subjects;
    public string $role = 'teacher';

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName, array $subjects){
        parent::__construct($id, $username, $password, $firstName, $lastName);
        $this->subjects = $subjects;
    }

    public function run($subjects, $users){
        $currentTeacherSubjects = implode(", ", $this->subjects);
        echo "The subjects that you teach are: $currentTeacherSubjects\n";
        echo "Teacher menu\n";
        echo "1. Grade a student\n";
        echo "2. Log out\n";

        $fin = fopen("php://stdin", "r");
        echo "Enter an option from 1 to 7: ";
        $inputOption = trim(fgets($fin));
        if ($inputOption == "1") {
            $this->gradeStudent($subjects, $users);
        }
        else if ($inputOption == "2") {
            $this->logOut();
        }
    }

    public function gradeStudent($subjects, $users){
        echo "Choose a student from the list by typing their id:\n";
        $this->printUsersByRole($users, "student");

        $fin = fopen("php://stdin", "r");
        $studentId = trim(fgets($fin));
        $studentIdStatus = false;
        while(!$studentIdStatus){
            foreach ($users as $user) {
                if($user->id == $studentId){
                    $studentIdStatus = true;
                }
            }
            echo "Invalid input! Please enter a valid id: ";
            $fin = fopen("php://stdin", "r");
            $studentId = trim(fgets($fin));
        }



        if($users[$studentId-1]){
            $currentUser = $users[$studentId-1];
            $subjectNumber = 0;
            echo "Choose a subject to grade from the list:\n";

            foreach ($currentUser->subjectsAndGrades as $subject => $grades){
                    ++$subjectNumber;
                    echo "$subjectNumber. " . $subject . PHP_EOL;
            }

            $fin = fopen("php://stdin", "r");
            $subjectInput = trim(fgets($fin));
            while ($subjectInput  > $subjectNumber || $subjectInput  < 1) {
                echo "Invalid subject id! Please enter a valid id:\n";
                $fin = fopen("php://stdin", "r");
                $subjectInput  = trim(fgets($fin));
            }

            echo "Enter a grade 2-6: ";
            $fin = fopen("php://stdin", "r");
            $gradeInput = trim(fgets($fin));
            while($gradeInput < 2 || $gradeInput > 6){
                echo "Invalid input! Please enter a valid grade: ";
                $fin = fopen("php://stdin", "r");
                $gradeInput = trim(fgets($fin));
            }

            $subjectKeys = array_keys($currentUser->subjectsAndGrades);
            $currentSubject = $subjectKeys[$subjectInput-1];
            $subjectGrades = $currentUser->subjectsAndGrades[$currentSubject];
            array_push($subjectGrades, $gradeInput);
            $currentUser->subjectsAndGrades[$currentSubject] = $subjectGrades;
            echo "Student graded successfully!\n";
        }
        $this->run($subjects, $users);
    }
}